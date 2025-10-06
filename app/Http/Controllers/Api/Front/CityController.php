<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\City\CityCollection;
use App\Http\Resources\City\CityProvinceResource;
use App\Services\CityService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(readonly private CityService $cityService)
    {
    }

    public function index(Request $request)
    {
        $cities = $this->cityService->all($request->toArray());
        return ApiResponse::success(data:new CityCollection($cities),message:'success');
    }

    public function show($id)
    {
        $city = $this->cityService->find($id);
        return ApiResponse::success(data:new CityProvinceResource($city),message:'success');
    }
}
