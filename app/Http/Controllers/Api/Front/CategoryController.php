<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Category\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct(readonly private CategoryService $categoryService)
    {
    }

    public function index(Request $request)
    {
        $request['status']==1;
        $categories = $this->categoryService->all($request->toArray());
        return ApiResponse::success(data:new CategoryCollection($categories),message:'success');
    }

    public function show($slug)
    {
        $category = $this->categoryService->findBySlug($slug);
        return ApiResponse::success(data: new CategoryResource($category), message: 'success');
    }
}
