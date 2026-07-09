<?php

namespace App\Http\Controllers;

use App\Services\BlogService;
use App\Http\Resources\SingleBlogResource;
use App\Http\Resources\MultiBlogResource;
use App\Http\Resources\DetailBlogResource;
use App\Http\Requests\CreateBlogRequest;
use App\Http\Requests\BatchUpdateBlogRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BlogController extends Controller
{
    public function __construct(private BlogService $service) {}

    public function createBlog(CreateBlogRequest $request)
    {
        Log::info('Incoming request createBlog: ', $request->validated());

        try {
            $data = $this->service->createBlog($request->validated());
            return $this->successResponse(new SingleBlogResource($data), 'success', 201);
        } catch (\Exception $e) {
            Log::error('Error inserting record', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }

    public function batchUpdateBlog(BatchUpdateBlogRequest $request)
    {
        Log::info('Incoming request batchUpdateBlog: ', ['blogs'=>$request->validated()['blogs']]);
        
        try {
            $this->service->batchUpdate($request->validated()['blogs']);
            return $this->successResponse(null, 'updated');
        } catch (\Exception $e) {
            Log::error('Error inserting record', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }

    public function getBlogAll(Request $request)
    {
        try {
            Log::info('Incoming request getBlogAll');

            $perPage = $request->query('per_page', 10);
            $data = $this->service->getDataAll($perPage);
            return $this->successResponse([
                'blogs'=>MultiBlogResource::collection($data),
                'pagination' => [
                    'total'        => $data->total(),
                    'per_page'     => $data->perPage(),
                    'current_page' => $data->currentPage(),
                    'last_page'    => $data->lastPage(),
                ],
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Not found', 404);
        } catch (\Exception $e) {
            Log::error('Error fetching record', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }

    public function getBlog(string $title)
    {
        try {
            Log::info('Incoming request getBlog');

            $data = $this->service->getByTitle($title);
            return $this->successResponse(new SingleBlogResource($data));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return $this->errorResponse('Not found', 404);
        } catch (\Exception $e) {
            Log::error('Error fetching record', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }

    public function getBlogDetailList()
    {
        try {
            Log::info('Incoming request get blog detail list');

            $data = $this->service->getBlogDetailList();
            
            if (empty($data)) {
                return $this->errorResponse('Not found', 404);
            }

            return $this->successResponse(DetailBlogResource::collection($data));

        } catch (\Exception $e) {
            Log::error('Error fetching detail', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }
    public function getBlogDetail(string $title)
    {
        try {
            Log::info('Incoming request get blog detail');

            $data = $this->service->getBlogDetailByTitle($title);
            
            if (empty($data)) {
                return $this->errorResponse('Not found', 404);
            }

            return $this->successResponse([
                'blogs' => new DetailBlogResource($data),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching detail', ['error' => $e->getMessage()]);
            return $this->errorResponse('failed');
        }
    }
}
