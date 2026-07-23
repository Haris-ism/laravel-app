<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
            "edit.title.{$post->id}" => 'title test',
            "edit.content.{$post->id}" => 'content test',
        ];

        $response = Livewire::actingAs($user)
            ->test('blog-manage')
            ->set($input)
            ->call('stageEdit', $post->id);

        $response->assertSessionHas('pending_edits.'.$post->id, [
            'id' => $post->id,
            'title' => $input["edit.title.{$post->id}"],
            'content' => $input["edit.content.{$post->id}"],
        ]);
    }

    public function test_update_stage_different_user(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        $input = [
            "edit.title.{$post->id}" => 'title test',
            "edit.content.{$post->id}" => 'content test',
        ];
        $user2 = User::factory()->create();

        Livewire::actingAs($user2)
            ->test('blog-manage')
            ->set($input)
            ->call('stageEdit', $post->id)
            ->assertRedirect(route('blog.blogPage'));

        $this->assertEquals('Unauthorized user', session('error'));
    }

    public function test_update_stage_unauthenticated(): void
    {
        $response = $this->get(route('blog.blogManagePage'));

        $response->assertRedirect(route('blog.blogPage'));
        $this->assertGuest();
        $response->assertSessionHas('url.intended');
    }
}
