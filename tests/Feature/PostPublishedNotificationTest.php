<?php

namespace Tests\Feature;

use App\Events\PostPublished;
use App\Models\User;
use App\Notifications\PostPublishedNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class PostPublishedNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_notification_create_blog_event_send(): void
    {
        Event::fake();

        $user = User::factory()->create();
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->set($input)
            ->call('createBlog');

        Event::assertDispatched(PostPublished::class, function (PostPublished $event) use ($input) {
            return $event->post->title === $input['title'];
        });
    }

    public function test_notification_create_blog_email(): void
    {
        Notification::fake();

        $user = User::factory()->create();
        $input = [
            'title' => 'title test',
            'content' => 'content test',
        ];

        Livewire::actingAs($user)
            ->test('blog-manage')
            ->set($input)
            ->call('createBlog');

        Notification::assertSentTo($user, PostPublishedNotification::class);
    }
}
