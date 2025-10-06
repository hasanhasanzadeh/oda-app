<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Content\ContentResource;
use App\Services\ContentService;

class ContentController extends Controller
{
    public function __construct(readonly private ContentService $contentService)
    {
    }

    public function show($type)
    {
        $content = $this->contentService->getByType($type);
        return ApiResponse::success(data:new ContentResource($content),message:'success');
    }
}
