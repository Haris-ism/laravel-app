<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DeleteBlogTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_delete_blog_success(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->call('deleteBlog', $post->id);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_delete_blog_different_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $user2 = User::factory()->create();

        Livewire::actingAs($user2)
            ->test('blog-manage')
            ->call('deleteBlog', $post->id)
            ->assertRedirect(route('blog.blogPage'));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_delete_blog_unauthenticated(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $response = $this->get(route('blog.blogManagePage'));

        $response->assertRedirect(route('blog.blogPage'));
        $this->assertGuest();
        $response->assertSessionHas('url.intended');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }
}
