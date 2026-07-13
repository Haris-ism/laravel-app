<?php

namespace App\Services;
use App\Models\Post;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;


class BlogService
{

   public function createBlog(array $data): bool
    {
        try{
            Post::create($data);
        }catch(\Throwable $e){
            Log::error("createBlog error: ",['error:'=>$e->getMessage()]);
            return false;
        }
        return true;
    }

   public function batchUpdate(): bool
    {
        $pending = session('pending_edits', []);

        if (empty($pending)) {
            return true;
        }
        try {
            DB::transaction(function () use ($pending) {
                foreach ($pending as $p) {
                    Post::where('id', $p['id'])->update([
                        'title'   => $p['title'],
                        'content' => $p['content'],
                    ]);
                }
            });
        } catch (\Throwable $e) {
            Log::error("batchUpdate error: ",['error:'=>$e->getMessage()]);
            return false;
        }
        session()->forget('pending_edits');
        return true;
    }


    public function getDataAll(int $perPage = 10): LengthAwarePaginator|null
    {
        try{
            $post=Post::orderBy('created_at', 'desc')->paginate($perPage);
        }catch(\Throwable $e){
            Log::error("getDataAll error: ",['error:'=>$e->getMessage()]);
            return null;
        }
        return $post;
    }

    public function getBlogDetailByTitle(string $title): Post|null
    {
        try {
            $post=Post::with('comments')->where('title', $title)->firstOrFail();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error("getBlogDetailByTitle error: ",['error:'=>$e->getMessage()]);
            return null;
        }
        return $post;
    }

    public function getBlogDetailList(): array|object
    {
        // // eloquent with() version
        $posts = Post::with('comments')->get();

        return $posts->all();
    }

    public function updatePage(int $id): Post|null
    {
        try{
            $post=Post::findOrFail($id);
            $pending = session('pending_edits.' . $id);
    
            if ($pending) {
                $post->title = $pending['title'];
                $post->content = $pending['content'];
            }
        }catch(\Throwable $e){
            Log::error("updatePage error: ",['error:'=>$e->getMessage()]);
            return null;
        }

        return $post;
    }

    public function updateStage(int $id, array $data): bool
    {
        try{
            Post::findOrFail($id);

            $pending = session('pending_edits', []);
            $pending[$id] = [
                'id' => $id,
                'title' => $data['title'],
                'content' => $data['content'],
            ];

            session(['pending_edits' => $pending]);
        }catch (\Throwable $e) {
            Log::error("updateStage error: ",['error:'=>$e->getMessage()]);
            return false;
        }

        return true;
    }
    public function blogManagePage(): array|null
    {
        try{
            $data = Post::orderBy('created_at', 'desc')->paginate(10);
            $pending = session('pending_edits', []);
        }catch(\Throwable $e) {
            Log::error("blogManagePage error: ",['error:'=>$e->getMessage()]);
            return null;
        }

        return [
            'data'=>$data,
            'pending'=>$pending,
        ];
    }
}
