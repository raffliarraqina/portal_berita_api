<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// login
Route::post('login', [\App\Http\Controllers\API\AuthController::class, 'login']);
// register
Route::post('register', [\App\Http\Controllers\API\AuthController::class, 'register']);
//logout
Route::post('logout', [\App\Http\Controllers\API\AuthController::class, 'logout'])->middleware('auth:sanctum');
// update password
Route::put('update-password', [\App\Http\Controllers\API\AuthController::class, 'updatePassword'])->middleware('auth:sanctum');

// get all user
Route::get('getAllUser', [\App\Http\Controllers\API\UserController::class, 'getAllUser']);
// get user by id
Route::get('getUserById/{id}', [\App\Http\Controllers\API\UserController::class, 'getUserById']);

// category
Route::get('category', [\App\Http\Controllers\API\CategoryController::class, 'index']);
// show category
Route::get('category/{id}', [\App\Http\Controllers\API\CategoryController::class, 'show']);
// category create
Route::post('category', [\App\Http\Controllers\API\CategoryController::class, 'create'])->middleware('auth:sanctum');
// category delete
Route::delete('category/{id}', [\App\Http\Controllers\API\CategoryController::class, 'destroy'])->middleware('auth:sanctum');

// slider
Route::get('slider', [\App\Http\Controllers\API\SliderController::class, 'index']);
// slider create
Route::post('slider', [\App\Http\Controllers\API\SliderController::class, 'create'])->middleware('auth:sanctum');
// slider delete
Route::delete('slider/{id}', [\App\Http\Controllers\API\SliderController::class, 'destroy'])->middleware('auth:sanctum');

// news 
Route::get('news', [\App\Http\Controllers\API\NewsController::class, 'index']);
Route::get('news/{id}', [\App\Http\Controllers\API\NewsController::class, 'show']);
