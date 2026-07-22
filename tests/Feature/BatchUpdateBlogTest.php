<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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

        session(['pending_edits' => $pending]);

        $response = Livewire::actingAs($user)
            ->test('blog-manage')
            ->call('batchUpdate');

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

        session(['pending_edits' => $pending]);

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->call('batchUpdate')
            ->assertDispatched('notify', type: 'error');

        foreach ($posts as $post) {
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
            ]);
        }
    }

    public function test_batch_update_unauthenticated(): void
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

        session(['pending_edits' => $pending]);

        $response = $this->get(route('blog.blogManagePage'));
        $response->assertRedirect(route('blog.blogPage'));

        $this->assertGuest();
        foreach ($pending as $data) {
            $this->assertDatabaseMissing('posts', [
                'id' => $data['id'],
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
        }
    }

    public function test_batch_update_invalid_pending_data(): void
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
        $pending[99999] = [
            'id' => 99999,
            'title' => 'invalid title',
            'content' => 'invalid content',
        ];

        session(['pending_edits' => $pending]);

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->call('batchUpdate')
            ->assertDispatched('notify', type: 'error');

        foreach ($pending as $data) {
            $this->assertDatabaseMissing('posts', [
                'id' => $data['id'],
                'title' => $data['title'],
                'content' => $data['content'],
            ]);
        }
    }
}
