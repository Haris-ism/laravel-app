<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\StageUpdateBlogRequest;
use App\Models\User;
use App\Services\BlogService;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
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

    // public function createBlogPage(Request $request)
    // {
    //     try {
    //         $this->service->getUser($request->user()->id);
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('blogDetailPage not found error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogPage')->with('error', 'Unauthenticated');
    //     } catch (QueryException $e) {
    //         Log::error('blogDetailPage query error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogPage')->with('error', 'Something went wrong. Please try again.');
    //     }

    //     return view('components.modals.create');
    // }

    // public function createBlog(CreateBlogRequest $request)
    // {
    //     try {
    //         $this->service->createBlog($request->validated(),$request->user()->id);
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('createBlog not found error: ', ['error:' => $e->getMessage(), 'model:' => $e->getModel()]);

    //         return match ($e->getModel()) {
    //             User::class => redirect()->route('blog.blogPage')->with('error', 'Unauthenticated'),
    //             default => redirect()->route('blog.blogPage')->with('error', 'Something went wrong.'),
    //         };
    //     } catch (QueryException $e) {
    //         Log::error('createBlog query error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
    //     }

    //     return redirect()->route('blog.blogManagePage')->with('status', 'Blog post created');
    // }

    // public function deleteBlog(int $id)
    // {
    //     try {
    //         $post = $this->service->getBlogById($id);
    //         $this->authorize('delete', $post);
    //         $this->service->deleteBlog($post);
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('deleteBlog not found error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found.');
    //     } catch (AuthorizationException $e) {
    //         Log::error('deleteBlog unauthorized error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Unauthorized user');
    //     } catch (QueryException $e) {
    //         Log::error('deleteBlog query error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
    //     }

    //     return redirect()->route('blog.blogManagePage')->with('status', 'Blog post deleted');
    // }

    // public function updatePage(int $id)
    // {
    //     try {
    //         $post = $this->service->updatePage($id);
    //         $this->authorize('update', $post);
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('updatePage not found error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found');
    //     } catch (AuthorizationException $e) {
    //         Log::error('updatePage unauthorized error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Unauthorized user');
    //     } catch (QueryException $e) {
    //         Log::error('updatePage query error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong.');
    //     }

    //     return view('components.modals.edit', ['post' => $post]);
    // }

    // public function updateStage(int $id, StageUpdateBlogRequest $request)
    // {
    //     try {
    //         $post = $this->service->getBlogById($id);
    //         $this->authorize('update', $post);
    //         $this->service->updateStage($post, $request->validated());
    //     } catch (ModelNotFoundException $e) {
    //         Log::error('updateStage not found error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Blog post not found.');
    //     } catch (AuthorizationException $e) {
    //         Log::error('updateStage unauthorized error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Unauthorized user');
    //     } catch (QueryException $e) {
    //         Log::error('updateStage query error: ', ['error:' => $e->getMessage()]);

    //         return redirect()->route('blog.blogManagePage')->with('error', 'Something went wrong. Please try again.');
    //     }

    //     return redirect()->route('blog.blogManagePage')->with('status', 'Blog post staged');
    // }

}
