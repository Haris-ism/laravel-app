<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UpdateBlogStageTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_update_stage_success(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $input = [
            'title' => $post->title.'test',
            'content' => $post->content.'test',
        ];

        $response = $this->actingAs($user)->put(route('blog.updateStage', $post->id), $input);

        $response->assertRedirect(route('blog.blogManagePage'));

        $response->assertSessionHas('pending_edits.'.$post->id, [
            'id' => $post->id,
            'title' => $input['title'],
            'content' => $input['content'],
        ]);

    }

    public function test_update_stage_different_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $user2 = User::factory()->create();

        $input = [
            'title' => $post->title.'test',
            'content' => $post->content.'test',
        ];

        $response = $this->actingAs($user2)->put(route('blog.updateStage', $post->id), $input);

        $response->assertRedirect(route('blog.blogManagePage'));
        $response->assertSessionHas('error', 'Unauthorized user');

    }
}
