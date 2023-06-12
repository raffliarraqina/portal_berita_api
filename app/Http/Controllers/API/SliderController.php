<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SliderController extends Controller
{
    public function index()
    {
        try {
            $slider = Slider::latest()->paginate('10');

            if ($slider) {
                return ResponseFormatter::success($slider, 'Data slider Berhasil diambil');
            } else {
                return ResponseFormatter::error(null, 'Data slider Tidak Ada', 404);
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
                'url' => 'required|string|max:255',
                'image' => 'required|mimes:png,jpg,jpeg,webp'
            ]);

            // upload image
            $image = $request->file('image');
            $image->storeAs('public/sliders', $image->hashName());

            // create
            $slider = Slider::create([
                'url' => $request->url,
                'image' => $image->hashName()
            ]);

            if ($slider) {
                return ResponseFormatter::success($slider, 'Data slider berhasil ditambahkan');
            } else {
                return ResponseFormatter::error(null, 'Data slider Gagal ditambahkan');
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
            $slider = Slider::findOrFail($id);
            // delete slider
            Storage::disk('local')->delete('public/sliders/' . basename($slider->image));
            // delete data
            $slider->delete();

            if ($slider) {
                return ResponseFormatter::success($slider, 'Data slider Berhasil DiHapus');
            } else {
                return ResponseFormatter::error(null, 'Data slider$slider Tidak Ada', 404);
            }

        } catch (\Error $error) {
            return ResponseFormatter::error([
                'data' => null,
                'message' => 'Data Gagal di Hapus',
                'error' => $error
            ]);
        }
    }
}
