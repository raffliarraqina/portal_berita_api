<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Console\View\Components\Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        try {
            $category = Category::latest()->paginate('10');

            if ($category) {
                return ResponseFormatter::success($category, 'Data Category Berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data Category Tidak Ada', 404);
            }
        } catch (\Error $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function create(Request $request)
    {
        try {
            //validate request
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'image' => 'required|mimes:png,jpg,jpeg,webp'
            ]);

            // upload image
            $image = $request->file('image');
            $image->storeAs('public/categories', $image->hashName());

            // create
            $category = Category::create([
                'name' => $request->name,
                'slug' => Str::slug($request->name, '_'),
                'image' => $image->hashName()
            ]);

            if ($category) {
                return ResponseFormatter::success($category, 'Data Category berhasil ditambahkan');
            } else {
                return ResponseFormatter::error(null, 'Data Category Gagal ditambahkan');
            }

        } catch (\Error $error) {
            return ResponseFormatter::error([
                'data' => null,
                'message' => 'Data Gagal Ditambahkan',
                'error' => $error
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            // delete image
            Storage::disk('local')->delete('public/categories/' . basename($category->image));
            // delete data
            $category->delete();

            if ($category) {
                return ResponseFormatter::success($category, 'Data Category Berhasil DiHapus');
            } else {
                return ResponseFormatter::error(null, 'Data Category Tidak Ada', 404);
            }

        } catch (\Error $error) {
            return ResponseFormatter::error([
                'data' => null,
                'message' => 'Data Gagal di Hapus',
                'error' => $error
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        try {

            //request validate
            $this->validate($request, [
                'name' => 'required|unique:categpries,name,' . $id,
                'image' => 'mimes:png,jpg,jpeg,webp|max:2000'
            ]);

            // get data category by id
            $category = Category::findOrFail($id);

            // check jika image kosong
            if ($request->file('image') == '') {

                // update data lama tanpa image
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name, '-')
                ]);

                if ($category) {
                    return ResponseFormatter::success($category, 'Data Category Berhasil diupdate');
                } else {
                    return ResponseFormatter::error(null, 'Data Gagal tidak ada', 404);
                }
            } else {

                // delete image lama
                Storage::disk('local')->delete('public/categories/' . basename($category->image));

                // upload image baru
                $image = $request->file('image');
                $image->storeAs('public/categories' , $image->hashName());

                // update data dengan image baru
                $category->update([
                    'name' => $request->name,
                    'slug' => Str::slug($request->name, '-'),
                    'image' => $image->hashName()
                ]);
                
                if ($category) {
                    return ResponseFormatter::success($category, 'Data Category Berhasil diupdate');
                } else {
                    return ResponseFormatter::error(null, 'Data Gagal tidak ada', 404);
                }
            }

        } catch (\Error $error) {

            return ResponseFormatter::error([
                'data' => null,
                'message' => 'Data Gagal Update',
                'error' => $error
            ]);

        }
    }

    public function show($id)
    {
        try {

            $category = Category::findOrFail($id);

            if($category) {
                return ResponseFormatter::success($category, 'Data Berhasil Di Tampilkan');
            } else {
                return ResponseFormatter::error(null, 'Data Gagal Di Tampilkan', 404);
            }

        } catch (\Error $error) {

            return ResponseFormatter::error([
                'data' => null,
                'message' => 'Data Gagal Di Tampilkan',
                'error' => $error
            ]);

        }
    }

}
