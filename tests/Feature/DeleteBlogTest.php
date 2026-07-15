<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
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

        $this->actingAs($user)->delete(route('blog.deleteBlog', $post->id));

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }

    public function test_delete_blog_different_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $user2 = User::factory()->create();

        $response = $this->actingAs($user2)->delete(route('blog.deleteBlog', $post->id));
        $response->assertRedirect(route('blog.blogManagePage'));
        $response->assertSessionHas('error', 'Unauthorized user');

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
        ]);
    }
}
