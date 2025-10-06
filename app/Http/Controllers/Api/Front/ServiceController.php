<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Service\ServiceCollection;
use App\Services\ServiceService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function __construct(readonly private ServiceService $serviceService)
    {
    }

    public function index(Request $request)
    {
        $faqs = $this->serviceService->all($request->toArray());
        return ApiResponse::success(data:new ServiceCollection($faqs),message:'success');
    }
}
