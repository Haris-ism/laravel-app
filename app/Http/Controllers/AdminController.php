<?php

namespace App\Http\Controllers;

use App\Services\AdminService;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{
    public function __construct(private AdminService $service) {}

    public function getUsers()
    {
        try {
            $data = $this->service->getUsers();
        } catch (QueryException $e) {
            Log::error('getUsers query error: ', ['error:' => $e->getMessage()]);

            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong. Please try again.');
        }

        return view('pages.admin', ['users' => $data]);
    }
}
