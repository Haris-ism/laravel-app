<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Comment::factory()->count(20)->create();
        Comment::factory()->count(20)->recycle(Post::all())->create(); // recycle is used for existing created data
    }
}
