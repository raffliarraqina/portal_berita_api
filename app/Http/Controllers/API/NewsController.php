<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        try {
            $news = News::latest()->paginate('10');

            if ($news) {
                return ResponseFormatter::success($news, 'Data News Berhasil Diambil');
            } else {
                return ResponseFormatter::error(null, 'Data News Gagal Diambil', 404);
            }
        } catch (\Error $error) {
            return ResponseFormatter::error([
                'message' => 'Something Went Wrong',
                'error' => $error
            ], 'Authentication Failed', 500);
        }
    }

    public function show($id)
    {
        try {

            $news = News::findOrFail($id);

            if ($news) {
                return ResponseFormatter::success($news, 'Data Berhasil Di Tampilkan');
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
