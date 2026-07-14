<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\BlogService;
use Illuminate\Auth\Access\AuthorizationException;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\BatchUpdateBlogRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StageUpdateBlogRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;


class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}


    public function blogPage(Request $request)
    {
        $perPage = $request->query('per_page', 5);

        try {
            $data = $this->service->getDataAll($perPage);
        } catch (QueryException $e) {
            Log::error("blogPage error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong');
        }

        return view('pages.index', ['data' => $data]);
    }

    public function blogManagePage()
    {
        try {
            $data = $this->service->blogManagePage();
        } catch (QueryException $e) {
            Log::error("blogManagePage error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong');
        }

        return view('pages.manage', $data);
    }

    public function blogDetailPage(string $title)
    {
        try {
            $data = $this->service->getBlogDetailByTitle($title);
        } catch (ModelNotFoundException $e) {
            Log::error("blogDetailPage not found error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogPage')->with('error', 'Blog not found');
        } catch (QueryException $e) {
            Log::error("blogDetailPage query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogPage')->with('error', 'Something went wrong. Please try again.');
        }

        return view('pages.detail', ['title' => $title, 'data' => $data]);
    }

    public function createBlogPage()
    {
        return view('components.modals.create');
    }

    public function createBlog(CreateBlogRequest $request)
    {
        $data = [...$request->validated(), 'user_id' => $request->user()->id];

        try {
            $this->service->createBlog($data);
        } catch (ModelNotFoundException $e) {
            Log::error("createBlog not found error: ",['error:'=>$e->getMessage(), 'model:'=>$e->getModel()]);
            return match ($e->getModel()) {
                User::class => redirect()->route('blog.blogManagePage')->with('error', 'User not found'),
                default => redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.'),
            };
        } catch (QueryException $e) {
            Log::error("createBlog query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post created');
    }

    public function deleteBlog(int $id)
    {
        try {
            $post = $this->service->getBlogById($id);
        } catch (ModelNotFoundException $e) {
            Log::error("deleteBlog not found error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found.');
        }

        try {
            $this->authorize('delete', $post);
        } catch (AuthorizationException $e) {
            Log::error("deleteBlog unauthorized error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Unauthorized user');
        }

        try {
            $this->service->deleteBlog($post);
        } catch (QueryException $e) {
            Log::error("deleteBlog query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post deleted');
    }

    public function updatePage(int $id)
    {
        try {
            $post = $this->service->updatePage($id);
        } catch (ModelNotFoundException $e) {
            Log::error("updatePage not found error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found');
        } catch (QueryException $e) {
            Log::error("updatePage query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
        }

        $this->authorize('update', $post);

        return view('components.modals.edit', ['post' => $post]);
    }

    public function updateStage(int $id, StageUpdateBlogRequest $request)
    {
        try {
            $post = $this->service->getBlogById($id);
        } catch (ModelNotFoundException $e) {
            Log::error("updateStage not found error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found.');
        }

        $this->authorize('update', $post);

        try {
            $this->service->updateStage($post, $request->validated());
        } catch (QueryException $e) {
            Log::error("updateStage query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post staged');
    }

    public function batchUpdate()
    {
        try {
            $this->service->batchUpdate();
        } catch (QueryException $e) {
            Log::error("batchUpdate query error: ",['error:'=>$e->getMessage()]);
            return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
        }

        return redirect()->route('blog.blogManagePage')->with('status', 'Blog post updated');
    }
}
