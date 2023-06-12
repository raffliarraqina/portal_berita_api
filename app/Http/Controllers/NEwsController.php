<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use RealRashid\SweetAlert\Facades\Alert;

class NEwsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $news = News::latest()->paginate('4');
        $category = Category::all();

        return view('admin.news.index', compact('news', 'category'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $news = News::all();
        $category = Category::all();

        return view('admin.news.create', compact('news', 'category')); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'image' => 'required|mimes:png,jpg,jpeg',
            'description' => 'required'
        ]);
        $image = $request->file('image');
        $image->storeAs('public/newss/', $image->hashName());

        //save to DB
        News::create([
            'category_id' => $request->category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'image' => $image->hashName(),
            'description' => $request->description
        ]);

        return redirect()->route('news.index')->with([
            Alert::success(
                'Success Title', 
                'Success Message')
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::all();
        $news     = News::findOrFail($id);

        return view('admin.news.show', compact('category', 'news'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::all();
        $news     = News::findOrFail($id);

        return view('admin.news.edit', compact('category', 'news'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, News $news)
    {
        $this->validate($request,[
            'title' => 'required|unique:news,title,' . $news->id,
            'image' => 'mimes:png,jpg,jpeg'
        ]);

        if ($request->file('image') == ''){
            $news = News::findOrFail($news->id);
            $news->update([
                'title' => $request->title,
                'category_id' => $request->category_id,
                'slug' => Str::slug($request->title, '-'),
                'description' => $request->description
            ]);
        }else {
            Storage::disk('local')->delete('public/newss/'. basename($news->image));

            $image = $request->file('image');
            $image->storeAs('public/newss', $image->hashName());

            $news = News::findOrFail($news->id);
            $news->update([
                'image' => $image->hashName(),
                'title' => $request->title,
                'description' => $request->description,
                'slug' => Str::slug($request->title, '-'),
                'category_id' => $request->category_id
            ]);
    }
    if ($news){
        
    return redirect()->route('news.index')->with([
        Alert::success('success', 'Berhasil Diupdate')
    ]);
}else{
        return redirect()->route('news.index')->with([
            Alert::error('Error', 'Gagal Diupdate')
        ]);
        
    }
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $news = News::findOrFail($id);
        Storage::disk('local')->delete('public/newss/' . basename($news->image));
        $news->delete();

        return redirect()->route('news.index')->with([
            Alert::success('Succes', 'Berhasil dihapus')
        ]);
    }

    public function searchNews(Request $request)
    {
        $keyword = $request->keyword;
        $news = News::where('title', 'like', '%' . $keyword . '%')->paginate(5);

        return view('admin.news.index', compact('news'));
    }
}
