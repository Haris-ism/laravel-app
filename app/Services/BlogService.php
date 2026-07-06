<?php

namespace App\Services;
use App\Models\Table1;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;


class BlogService
{
   public function createBlog(array $data): Table1
    {
        return Table1::create($data);
    }

   public function batchUpdate(array $data): void
    {
        DB::transaction(function () use ($data) {
            foreach ($data as $d) {
                Table1::where('id', $d['id'])->update([
                    'title'   => $d['title'],
                    'content' => $d['content'],
                ]);
            }
        });
    }


    public function getDataAll(int $perPage = 10): LengthAwarePaginator
    {
        return Table1::orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getByTitle(string $title): Table1
    {
        return Table1::where('title', $title)->firstOrFail();
    }

    public function getDetailByTitle(string $title): array
    {
        return DB::select('SELECT * FROM table1 t1
            JOIN table2 t2 ON t1.id = t2.content_id
            WHERE t1.title = ?', [$title]);
    }
}
