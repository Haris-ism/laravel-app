<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}

    public function blogPage()
    {
        return view('pages.index');
    }

    public function blogManagePage()
    {
        return view('pages.manage');
    }

    public function blogDetailPage(string $title)
    {
        try {
            $data = $this->service->getBlogDetailByTitle($title);
        } catch (ModelNotFoundException $e) {
            Log::error('blogDetailPage not found error: ', ['error:' => $e->getMessage()]);

            return redirect()->route('blog.blogPage')->with('error', 'Blog not found');
        } catch (QueryException $e) {
            Log::error('blogDetailPage query error: ', ['error:' => $e->getMessage()]);

            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong. Please try again.');
        }

        return view('pages.detail', ['title' => $title, 'data' => $data]);
    }

    public function batchUpdate()
    {
        try {
            $this->service->batchUpdate();
        } catch (QueryException $e) {
            Log::error('batchUpdate query error: ', ['error:' => $e->getMessage()]);

            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post updated');
    }
}
