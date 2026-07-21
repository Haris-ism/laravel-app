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
            'edit' => [
                'title' => [$post->id => $post->title.'test'],
                'content' => [$post->id => $post->content.'test'],
            ],
        ];

        $response = $this->actingAs($user)->put(route('blog.updateStage', $post->id), $input);

        $response->assertRedirect(route('blog.blogManagePage'));

        $response->assertSessionHas('pending_edits.'.$post->id, [
            'id' => $post->id,
            'title' => $input['edit']['title'][$post->id],
            'content' => $input['edit']['content'][$post->id],
        ]);

    }

    public function test_update_stage_different_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $user2 = User::factory()->create();

        $input = [
            'edit' => [
                'title' => [$post->id => $post->title.'test'],
                'content' => [$post->id => $post->content.'test'],
            ],
        ];

        $response = $this->actingAs($user2)->put(route('blog.updateStage', $post->id), $input);

        $response->assertRedirect(route('blog.blogManagePage'));
        $response->assertSessionHas('error', 'Unauthorized user');

    }

    public function test_update_stage_unauthenticated(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $input = [
            'edit' => [
                'title' => [$post->id => $post->title.'test'],
                'content' => [$post->id => $post->content.'test'],
            ],
        ];

        $response = $this->put(route('blog.updateStage', $post->id), $input);

        $response->assertRedirect(route('blog.blogPage'));
        $this->assertGuest();
        $response->assertSessionHas('url.intended');
    }
}
