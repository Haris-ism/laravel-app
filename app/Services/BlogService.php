<?php

namespace App\Services;
use App\Models\Post;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class BlogService
{

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

        $postId = Post::whereIn('id', array_column($pending, 'id'))->pluck('id')->all();
        $pendingFailed=[];
        foreach ($pending as $p) {
            if (!in_array($p['id'], $postId)) {
                //$pending[$p] key will always the same as $p['id'] since it is defined on update stage
                unset($pending[$p['id']]);
                $pendingFailed[]=$p['id'];
            }
        }

        if (count($pendingFailed)>0){
            session(['pending_edits' => $pending]);
            throw new \RuntimeException('Some staged posts no longer exist: ' . implode(',', $pendingFailed));
        }

        DB::transaction(function () use ($pending) {
            foreach ($pending as $p) {
                Post::where('id', $p['id'])->update([
                    'title'   => $p['title'],
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

    public function updateStage(Post $post, array $data): void
    {
        $pending = session('pending_edits', []);
        $pending[$post->id] = [
            'id' => $post->id,
            'title' => $data['edit']['title'][$post->id],
            'content' => $data['edit']['content'][$post->id],
        ];

        session(['pending_edits' => $pending]);
    }

    public function blogManagePage(): array
    {
        $data = Post::with('author')->orderBy('created_at', 'desc')->paginate(10);
        $pending = session('pending_edits', []);

        return [
            'data'=>$data,
            'pending'=>$pending,
        ];
    }

    public function getBlogById(int $id): Post
    {
        return Post::findOrFail($id);
    }
}
