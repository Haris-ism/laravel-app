<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->set($input)
            ->call('createBlog');

        $this->assertDatabaseHas('posts', [
            'title' => $input['title'],
            'content' => $input['content'],
            'user_id' => $user['id'],
        ]);
    }

    public function test_create_blog_empty_title(): void
    {
        $user = User::factory()->create();

        $input = [
            'title' => '',
            'content' => 'content test',
        ];

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->set($input)
            ->call('createBlog')
            ->assertHasErrors(['title' => 'required']);

        $this->assertDatabaseMissing('posts', [
            'content' => $input['content'],
        ]);
    }

    public function test_create_blog_unauthenticated(): void
    {
        $response = $this->get(route('blog.blogManagePage'));

        $response->assertRedirect(route('blog.blogPage'));

        $this->assertGuest();
        $response->assertSessionHas('url.intended');
    }
}
