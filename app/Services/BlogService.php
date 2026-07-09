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

    public function getBlogDetailByTitle(string $title): array|object
    {
        // eloquent with() version
        $post = Post::with('comments')->where('title', $title)->first();

        return $post ?? [];

        // // eloquent join version
        // $rows=Post::query()
        // ->leftJoin('comments','comments.post_id','=','posts.id')
        // ->where('posts.title',$title)
        // ->select(
        //     'posts.id',
        //     'posts.title',
        //     'posts.content',
        //     'posts.created_at',
        //     'comments.id as comment_id',
        //     'comments.post_id',
        //     'comments.comment',
        //     'comments.created_at as comment_created_at',
        // )
        // ->get();

        // if ($rows->isEmpty()) {
        //     return [];
        // }

        // //since title is unique, it is guaranteed datas[0] is always the same
        // $result= (object)[
        //     'id'=>$rows[0]->id,
        //     'title'=>$rows[0]->title,
        //     'content'=>$rows[0]->content,
        //     'created_at'=>$rows[0]->created_at,
        // ];

        // foreach ($rows as $data){
        //     $result->comments[]=[
        //         'id'=>$data->comment_id,
        //         'comment'=>$data->comment,
        //         'created_at'=>$data->comment_created_at,
        //         'post_id'=>$data->post_id,
        //     ];
        // };

        // return $result;
    }

    public function getBlogDetailList(): array|object
    {
        // // raw sql version
        // $rows = DB::select('SELECT
        //         p.id, p.title, p.content, p.created_at,
        //         c.id AS comment_id, c.post_id AS comment_post_id, c.comment AS comment
        //     FROM posts p
        //     LEFT JOIN comments c ON p.id = c.post_id');

        // $result = [];

        // foreach ($rows as $row) {
        //     if (! isset($result[$row->id])) {
        //         $result[$row->id] = (object) [
        //             'id'         => $row->id,
        //             'title'      => $row->title,
        //             'content'    => $row->content,
        //             'created_at' => $row->created_at,
        //             'comments'   => [],
        //         ];
        //     }

        //     if (! is_null($row->comment_id)) {
        //         $result[$row->id]->comments[] = [
        //             'comment_id'=>$row->comment_id,
        //             'comment' => $row->comment,
        //             'post_id' => $row->comment_post_id,
        //         ];
        //     }
        // }

        // return array_values($result);

        //=======================================

        // // eloquent join version
        // $rows = Post::query()
        //     ->leftJoin('comments', 'comments.post_id', '=', 'posts.id')
        //     ->select(
        //         'posts.id',
        //         'posts.title',
        //         'posts.content',
        //         'posts.created_at',
        //         'comments.id as comment_id',
        //         'comments.post_id as comment_post_id',
        //         'comments.comment as comment',
        //     )
        //     ->get();

        // if ($rows->isEmpty()) {
        //     return [];
        // }
        // $result = [];

        // foreach ($rows as $row) {
        //     if (! isset($result[$row->id])) {
        //         $result[$row->id] = (object) [
        //             'id'         => $row->id,
        //             'title'      => $row->title,
        //             'content'    => $row->content,
        //             'created_at' => $row->created_at,
        //             'comments'   => [],
        //         ];
        //     }

        //     if (! is_null($row->comment_id)) {
        //         $result[$row->id]->comments[] = [
        //             'comment' => $row->comment,
        //             'post_id' => $row->comment_post_id,
        //         ];
        //     }
        // }
        // return array_values($result);


        //=======================================
        // // N+1 problem
        // $posts = Post::get(); 

        // foreach ($posts as $post) {
        //     //silently query again
        //     $post->comments; 
        // }

        // return $posts->all();

        //=======================================
        // // eloquent with() version
        $posts = Post::with('comments')->get();

        return $posts->all();
    }
}
