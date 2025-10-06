<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionResource;
use App\Services\QuestionService;

class FaqController extends Controller
{
    public function __construct(readonly private QuestionService $questionService)
    {
    }

    public function index()
    {
        $faqs = $this->questionService->all();
        return ApiResponse::success(data:new QuestionResource($faqs),message:'success');
    }
}
