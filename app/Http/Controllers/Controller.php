<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function successResponse($data, string $message = 'success', int $status = 200)
    {

        return response()->json([
            'meta' => [
                'status' => 'success',
                'message' => $message,
            ],
            'data' => $data,
        ], $status);
    }

    protected function errorResponse(string $message, int $status = 500)
    {
        return response()->json([
            'meta' => [
                'status' => 'error',
                'message' => $message,
            ],
            'data' => null,
        ], $status);
    }
}
