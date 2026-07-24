<?php

namespace App\Listeners;

use App\Events\PostPublished;
use App\Notifications\PostPublishedNotification;

class SendPostPublishedNotification
{
    public function handle(PostPublished $event): void
    {
        $event->post->author->notify(new PostPublishedNotification($event->post));
    }
}
