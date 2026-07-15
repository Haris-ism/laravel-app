<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_register_success(): void
    {
        $input = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test12345678',
        ];

        $response = $this->post(route('auth.register'), $input);

        $response->assertRedirect(route('blog.blogPage'));

        $this->assertDatabaseHas('users', [
            'name' => $input['name'],
            'email' => $input['email'],
        ]);

        $user = User::where('email', $input['email'])->first();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check($input['password'], $user->password));
    }

    public function test_register_duplicate_email(): void
    {
        User::factory()->create(['email' => 'test@test.com']);

        $input = [
            'name' => 'test',
            'email' => 'test@test.com',
            'password' => 'test12345678',
        ];

        $response = $this->post(route('auth.register'), $input);

        $response->assertSessionHasErrors(['email'], null, 'register');
        $this->assertDatabaseCount('users', 1);

    }
}
