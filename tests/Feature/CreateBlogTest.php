<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_blog_success(): void
    {
        $user = User::factory()->create();

        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];

        $response = $this->actingAs($user)->post(route('blog.createBlog'), $input);

        $response->assertRedirect(route('blog.blogManagePage'));

        $this->assertDatabaseHas('posts', [
            'title' => $input['title'],
            'user_id' => $user->id,
        ]);
    }

    public function test_create_blog_empty_title(): void
    {
        $user = User::factory()->create();

        $input = [
            'title' => '',
            'content' => 'content test',
        ];

        $response = $this->actingAs($user)->post(route('blog.createBlog'), $input);

        $response->assertSessionHasErrors(['title'], null, 'create');
        $response->assertSessionHasInput('content', $input['content']);

        $this->assertDatabaseMissing('posts', [
            'content' => $input['content'],
        ]);
    }

    public function test_create_blog_unauthenticated(): void
    {
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];

        $response = $this->post(route('blog.createBlog'), $input);

        $response->assertRedirect(route('blog.blogPage'));

        $this->assertGuest();
        $response->assertSessionHas('url.intended');
        $this->assertDatabaseMissing('posts', [
            'title' => $input['title'],
            'content' => $input['content'],
        ]);

    }
}
