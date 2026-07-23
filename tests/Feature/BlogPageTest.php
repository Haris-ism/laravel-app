<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
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
        $response->assertSee('No blog yet');
    }

    public function test_blog_page_live_search(): void
    {
        Post::factory()->create(['title' => 'title test', 'content' => 'content test']);
        Post::factory()->create(['title' => 'input test', 'content' => 'content test']);

        Livewire::test('blog-index')
            ->set('search', 'title')
            ->assertSee('title test')
            ->assertDontSee('input test');
    }

    public function test_blog_page_live_search_no_results(): void
    {
        Post::factory()->create(['title' => 'title test', 'content' => 'content test']);

        Livewire::test('blog-index')
            ->set('search', 'something')
            ->assertSee('No blog found for "something"', false)
            ->assertDontSee('No blog yet');
    }
}
