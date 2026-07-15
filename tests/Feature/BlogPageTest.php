<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_page_success(): void
    {
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];
        Post::factory()->create($input);

        $response = $this->get(route('blog.blogPage'));

        $response->assertOk();
        $response->assertSee($input['title']);
        $response->assertSee($input['content']);
    }

    public function test_blog_page_shows_empty(): void
    {
        $response = $this->get(route('blog.blogPage'));

        $response->assertOk();
        $response->assertSee('No posts yet');
    }
}
