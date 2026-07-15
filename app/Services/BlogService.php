<?php

namespace App\Services;

use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class BlogService
{
    public function getUser(int $id): Post
    {
        return User::findOrFail($id);
    }

    public function createBlog(array $data): Post
    {
        User::findOrFail($data['user_id']);

        return Post::create($data);
    }

    public function deleteBlog(Post $post): bool
    {
        return $post->delete();
    }

    public function batchUpdate(): void
    {
        $pending = session('pending_edits', []);

        if (empty($pending)) {
            return;
        }

        DB::transaction(function () use ($pending) {
            foreach ($pending as $p) {
                Post::where('id', $p['id'])->update([
                    'title' => $p['title'],
                    'content' => $p['content'],
                ]);
            }
        });

        session()->forget('pending_edits');
    }

    public function getDataAll(int $perPage = 10): LengthAwarePaginator
    {
        return Post::with('author')->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getBlogDetailByTitle(string $title): Post
    {
        return Post::with('comments')->where('title', $title)->firstOrFail();
    }

    public function getBlogDetailList(): array|object
    {
        // // eloquent with() version
        $posts = Post::with('comments')->get();

        return $posts->all();
    }

    public function updatePage(int $id): Post
    {
        $post = Post::findOrFail($id);
        $pending = session('pending_edits.'.$id);

        if ($pending) {
            $post->title = $pending['title'];
            $post->content = $pending['content'];
        }

        return $post;
    }

    public function updateStage(Post $post, array $data): void
    {
        $pending = session('pending_edits', []);
        $pending[$post->id] = [
            'id' => $post->id,
            'title' => $data['title'],
            'content' => $data['content'],
        ];

        session(['pending_edits' => $pending]);
    }

    public function blogManagePage(): array
    {
        $data = Post::with('author')->orderBy('created_at', 'desc')->paginate(10);
        $pending = session('pending_edits', []);

        return [
            'data' => $data,
            'pending' => $pending,
        ];
    }

    public function getBlogById(int $id): Post
    {
        return Post::findOrFail($id);
    }
}
