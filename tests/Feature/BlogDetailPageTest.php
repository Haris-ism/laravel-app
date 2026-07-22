<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogDetailPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_detail_success(): void
    {
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];

        Post::factory()->create($input);

        $response = $this->get(route('blog.blogDetailPage', $input['title']));

        $response->assertOk();
        $response->assertSee($input['title']);
        $response->assertSee($input['content']);
    }

    public function test_blog_detail_not_found(): void
    {
        $response = $this->get(route('blog.blogDetailPage', 'not_found'));

        $response->assertRedirect(route('blog.blogPage'));
        $response->assertSessionHas('error', 'Blog not found');
    }
}
