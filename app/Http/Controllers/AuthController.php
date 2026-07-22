<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function __construct(private AuthService $service) {}

    public function login(LoginUserRequest $request)
    {
        $loginRes = $this->service->login($request->validated());

        if (! $loginRes) {
            return back()->withErrors(['email' => 'Invalid credentials.'], 'login')->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('blog.blogPage')->with('status', 'ログインしました');
    }

    public function register(RegisterUserRequest $request)
    {
        $registerRes = $this->service->register($request->validated());

        if (! $registerRes) {
            return back()->withErrors(['email' => 'Invalid Data'], 'register')->onlyInput('email');
        }

        $request->session()->regenerate();

        return redirect()->route('blog.blogPage')->with('status', '登録しました');
    }

    public function logout(Request $request)
    {
        $this->service->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('blog.blogPage')->with('status', 'ログアウトしました');
    }
}
