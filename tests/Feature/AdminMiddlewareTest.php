<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminMiddlewareTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_admin_page(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);

        $response = $this->actingAs($admin)->get(route('admin.getUsers'));

        $response->assertOk();
    }

    public function test_non_admin_cannot_access_admin_page(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $response = $this->actingAs($user)->get(route('admin.getUsers'));

        $response->assertForbidden();
    }

    public function test_guest_cannot_access_admin_page(): void
    {
        $response = $this->get(route('admin.getUsers'));

        $response->assertRedirect(route('blog.blogPage'));
        $this->assertGuest();
    }
}
