<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class AdminService
{
    /**
     * Create a new class instance.
     */
    public function getUsers(): LengthAwarePaginator
    {
        return User::orderBy('name')->paginate(10);
    }
}
