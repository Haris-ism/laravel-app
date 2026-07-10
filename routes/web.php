<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/blog/manage', function () {
//     return view('blog.manage');
// });

Route::get('/blog/manage', [BlogController::class, 'manage'])->name('blog.manage');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
Route::get('/blog/{id}/edit', [BlogController::class, 'edit'])->name('blog.edit');
Route::put('/blog/{id}', [BlogController::class, 'update'])->name('blog.update');
Route::post('/blog/save-pending', [BlogController::class, 'savePending'])->name('blog.save-pending');
Route::get('/blog/{title}', [BlogController::class, 'show'])->name('blog.show');
