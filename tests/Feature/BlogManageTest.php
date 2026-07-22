<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogManageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_manage_success(): void
    {
        $user = User::factory()->create();
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];
        Post::factory()->create([...$input, 'user_id' => $user->id]);

        $response = $this->actingAs($user)->get(route('blog.blogManagePage'));

        $response->assertOk();
        $response->assertSee($input['title']);
        $response->assertSee($input['content']);
    }

    public function test_blog_manage_unauthenticated(): void
    {
        $response = $this->get(route('blog.blogManagePage'));
        $response->assertRedirect(route('blog.blogPage'));
        $this->assertGuest();
        $response->assertSessionHas('url.intended');
    }
}
