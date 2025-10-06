<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Setting\SettingResource;
use App\Services\SettingService;

class SettingController extends Controller
{
    public function __construct(readonly private SettingService $settingService)
    {
    }

    public function showFirst()
    {
        $setting = $this->settingService->first();
        return ApiResponse::success(data:new SettingResource($setting),message:'success');
    }
}
