<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Blog\BlogCollection;
use App\Http\Resources\Blog\BlogResource;
use App\Services\BlogService;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function __construct(readonly private BlogService $blogService)
    {
    }

    public function index(Request $request)
    {
        $request['status']==1;
        $blogs = $this->blogService->all($request->toArray());
        return ApiResponse::success(data:new BlogCollection($blogs),message:'success');
    }

    public function show($slug)
    {
        $blog = $this->blogService->findBySlug($slug);
        return ApiResponse::success(data:new BlogResource($blog),message:'success');
    }
}
