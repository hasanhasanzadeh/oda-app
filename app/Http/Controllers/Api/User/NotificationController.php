<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    public function __construct(readonly private NotificationService $notificationService)
    {
    }

    public function show($id): JsonResponse
    {
        $this->notificationService->findAndDelete($id);
        return ApiResponse::success(data:[],message:'success');

    }
}
