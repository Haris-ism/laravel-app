<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PingController extends Controller
{
    public function ping(Request $request)
    {
        return response()->json(['message' => 'pong'], 200);
    }
}
