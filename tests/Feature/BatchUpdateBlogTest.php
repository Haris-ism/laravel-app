<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BatchUpdateBlogTest extends TestCase
{
    use RefreshDatabase;

    public function test_batch_update_success(): void
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 2; $i++) {
            Post::factory()->create([
                'user_id' => $user->id,
                'title' => 'title test'.$i,
                'content' => 'content test1'.$i,
            ]);
        }

        $posts = Post::get();
        $pending = [];

        foreach ($posts as $post) {
            $pending[$post->id] = [
                'id' => $post->id,
                'title' => $post->title.' update',
                'content' => $post->content.' update',
            ];
        }

        $response = $this->actingAs($user)
            ->withSession(['pending_edits' => $pending])
            ->post(route('blog.batchUpdate'));

        $response->assertRedirect(route('blog.blogManagePage'));

        foreach ($pending as $data) {
            $this->assertDatabaseHas('posts', [
                'id' => $data['id'],
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
        }

        $response->assertSessionMissing('pending_edits');
    }

    public function test_batch_update_rollback(): void
    {
        $user = User::factory()->create();
        for ($i = 0; $i < 2; $i++) {
            Post::factory()->create([
                'user_id' => $user->id,
                'title' => 'title test'.$i,
                'content' => 'content test1'.$i,
            ]);
        }

        $posts = Post::get();
        $pending = [];

        for ($i = 0; $i < 2; $i++) {
            // partially wrong data to test rollback
            if ($i == 1) {
                $pending[$posts[$i]->id] = [
                    'id' => $posts[$i]->id,
                    'title' => null,
                    'content' => $posts[$i]->content.' update',
                ];

                continue;
            }
            $pending[$posts[$i]->id] = [
                'id' => $posts[$i]->id,
                'title' => $posts[$i]->title.' update',
                'content' => $posts[$i]->content.' update',
            ];
        }

        $response = $this->actingAs($user)
            ->withSession(['pending_edits' => $pending])
            ->post(route('blog.batchUpdate'));

        $response->assertRedirect(route('blog.blogManagePage'));
        $response->assertSessionHas('error');

        foreach ($posts as $post) {
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ]);
        }
    }
}
