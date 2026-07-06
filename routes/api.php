<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PingController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

Route::post('/ping', [PingController::class, 'ping']);
// Route::post('/blog', [BlogController::class, 'createBlog']);
// Route::put('/blog', [BlogController::class, 'batchUpdateBlog']);
Route::get('/blog', [BlogController::class, 'getBlogAll']);
Route::get('/blog/{title}', [BlogController::class, 'getBlog']);
Route::get('/blog/detail/{title}', [BlogController::class, 'getDataDetail']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // protect existing routes
    Route::post('/blog',  [BlogController::class, 'createBlog']);
    Route::put('/blog',   [BlogController::class, 'batchUpdateBlog']);
});