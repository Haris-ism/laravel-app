<?php

use App\Http\Controllers\AdminController;
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
    Route::post('/blog/logout', [AuthController::class, 'logout'])->name('auth.logout');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'getusers'])->name('admin.getUsers');
});

Route::get('/blog/{title}', [BlogController::class, 'blogDetailPage'])->name('blog.blogDetailPage');
