<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PingController;

Route::post('/ping', [PingController::class, 'ping']);