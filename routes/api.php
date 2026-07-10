<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PingController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\AuthController;

Route::post('/ping', [PingController::class, 'ping']);
Route::get('/blog', [BlogController::class, 'getBlogAll']);
// Route::get('/blog/{title}', [BlogController::class, 'getBlog']);
Route::get('/blog/detail/list', [BlogController::class, 'getBlogDetailList']);
Route::get('/blog/detail/{title}', [BlogController::class, 'getBlogDetail']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/blog',  [BlogController::class, 'createBlog']);
    Route::put('/blog',   [BlogController::class, 'batchUpdateBlog']);
});