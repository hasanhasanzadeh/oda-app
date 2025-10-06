<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advertisement\AdvertisementLikeCollection;
use Illuminate\Http\JsonResponse;

class LikeController extends Controller
{
    public function like($id): JsonResponse
    {
        auth()->user()->likedAdvertisements()->toggle($id);

        return ApiResponse::success(data:[],message:'success');
    }

    public function index()
    {
        $advertisements = auth()->user()->likedAdvertisements()->get();
        return ApiResponse::success(data: new AdvertisementLikeCollection($advertisements),message:'success');
    }
}
