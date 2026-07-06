<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/blog', function () {
    return view('blog.index');
});

Route::get('/blog/manage', function () {
    return view('blog.manage');
});

Route::get('/blog/{title}', function (string $title) {
    return view('blog.detail', ['title' => $title]);
});
