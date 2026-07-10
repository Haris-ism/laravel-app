<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use App\Http\Requests\CreateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}

    public function index(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $data = $this->service->getDataAll($perPage);

        return view('blog.index', ['data' => $data]);
    }

    public function manage()
    {
        $data = $this->service->getDataAll(10);
        $pending = session('pending_edits', []);

        return view('blog.manage', ['data' => $data, 'pending' => $pending]);
    }

    public function show(string $title)
    {
        $data = $this->service->getBlogDetailByTitle($title);
        return view('blog.detail', ['title' => $title, 'data' => $data]);
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(CreateBlogRequest $request)
    {
        $this->service->createBlog($request->validated());

        return redirect()->route('blog.index')->with('status', '保存しました');
    }

    public function edit(int $id)
    {
        $post = $this->service->getById($id);
        $pending = session('pending_edits.' . $id);

        if ($pending) {
            $post->title = $pending['title'];
            $post->content = $pending['content'];
        }

        return view('blog.edit', ['post' => $post]);
    }

    public function update(int $id, CreateBlogRequest $request)
    {
        $pending = session('pending_edits', []);
        $pending[$id] = [
            'id' => $id,
            'title' => $request->validated()['title'],
            'content' => $request->validated()['content'],
        ];
        session(['pending_edits' => $pending]);

        return redirect()->route('blog.manage')->with('status', '変更をステージしました（Save Changes で反映されます）');
    }

    public function savePending()
    {
        $pending = session('pending_edits', []);

        if (! empty($pending)) {
            $this->service->batchUpdate(array_values($pending));
            session()->forget('pending_edits');
        }

        return redirect()->route('blog.manage')->with('status', '保存しました');
    }
}
