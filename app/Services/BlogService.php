<?php

namespace App\Services;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class BlogService
{

   public function createBlog(array $data): Post
    {
        return Post::create($data);
    }

   public function batchUpdate(array $data): void
    {
        DB::transaction(function () use ($data) {
            foreach ($data as $d) {
                Post::where('id', $d['id'])->update([
                    'title'   => $d['title'],
                    'content' => $d['content'],
                ]);
            }
        });
    }


    public function getDataAll(int $perPage = 10): LengthAwarePaginator
    {
        return Post::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByTitle(string $title): Post
    {
        return Post::with('comments')->where('title', $title)->firstOrFail();
    }

    public function getBlogDetailByTitle(string $title): Post|null
    {
        $post = Post::with('comments')->where('title', $title)->first();

        return $post;
    }

    public function getBlogDetailList(): array|object
    {
        $posts = Post::with('comments')->get();

        return $posts->all();
    }
}
