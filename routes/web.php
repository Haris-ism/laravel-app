<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', [BlogController::class, 'blogPage'])->name('blog.blogPage');

Route::middleware('guest')->group(function () {
    Route::post('/blog/login', [AuthController::class, 'login'])->name('auth.login');
    Route::post('/blog/register', [AuthController::class, 'register'])->name('auth.register');
});

Route::middleware('auth')->group(function () {
    Route::get('/blog/manage', [BlogController::class, 'blogManagePage'])->name('blog.blogManagePage');
    Route::get('/blog/create', [BlogController::class, 'createBlogPage'])->name('blog.createBlogPage');
    Route::post('/blog/create', [BlogController::class, 'createBlog'])->name('blog.createBlog');
    Route::get('/blog/{id}/edit', [BlogController::class, 'updatePage'])->name('blog.updatePage');
    Route::put('/blog/{id}', [BlogController::class, 'updateStage'])->name('blog.updateStage');
    Route::delete('/blog/{id}', [BlogController::class, 'deleteBlog'])->name('blog.deleteBlog');
    Route::post('/blog/batch-update', [BlogController::class, 'batchUpdate'])->name('blog.batchUpdate');
    Route::post('/blog/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::get('/blog/{title}', [BlogController::class, 'blogDetailPage'])->name('blog.blogDetailPage');
