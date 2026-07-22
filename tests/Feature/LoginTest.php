<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_login_success(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('test12345678'),
        ]);

        $input = [
            'email' => 'test@test.com',
            'password' => 'test12345678',
        ];

        $response = $this->post(route('auth.login'), $input);

        $response->assertRedirect(route('blog.blogPage'));

        $user = User::where('email', $input['email'])->first();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check($input['password'], $user->password));

    }

    public function test_login_invalid_email_password(): void
    {
        User::factory()->create([
            'email' => 'test@test.com',
            'password' => Hash::make('test12345678'),
        ]);

        $input = [
            'email' => 'test1@test.com',
            'password' => 'test123456789',
        ];

        $response = $this->from(route('blog.blogPage'))->post(route('auth.login'), $input);

        $response->assertRedirect(route('blog.blogPage'));
        $response->assertSessionHasErrors(['email'], null, 'login');

    }
}
