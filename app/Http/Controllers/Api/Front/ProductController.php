<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(readonly private ProductService $productService)
    {
    }

    public function index(Request $request)
    {
        $products = $this->productService->all($request->toArray());
        return ApiResponse::success(data:new ProductCollection($products),message:'success');
    }

    public function show($lug)
    {
        $product = $this->productService->findBySlug($lug);
        return ApiResponse::success(data:new ProductResource($product),message:'success');
    }
}
