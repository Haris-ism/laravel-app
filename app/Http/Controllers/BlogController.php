<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\StageUpdateBlogRequest;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}


    public function blogPage(Request $request)
    {
        $perPage = $request->query('per_page', 5);
        $data = $this->service->getDataAll($perPage);
        if (!$data) {
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong');
        }

        return view('pages.index', ['data' => $data]);
    }

    public function blogManagePage()
    {
        $data = $this->service->blogManagePage();
        if (!$data){
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong');
        }

        return view('pages.manage', $data);
    }

    public function blogDetailPage(string $title)
    {
        try {
            $data = $this->service->getBlogDetailByTitle($title);
        } catch (\Throwable $e) {
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong');
        }

        if (!$data) {
            return redirect()->route('blog.blogPage')->with('error', 'Blog not found');
        }

        return view('pages.detail', ['title' => $title, 'data' => $data]);
    }

    public function createBlog(CreateBlogRequest $request)
    {
        if (!$this->service->createBlog($request->validated())){
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong');
        }
        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post created');
    }

    public function updateStage(int $id, StageUpdateBlogRequest $request)
    {
        if (!$this->service->updateStage($id, $request->validated())){
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post staged');
    }

    public function batchUpdate()
    {
        if (!$this->service->batchUpdate()){
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
        }
        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post updated');
    }
}
