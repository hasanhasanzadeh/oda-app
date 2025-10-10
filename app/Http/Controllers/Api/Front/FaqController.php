<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Question\QuestionCollection;
use App\Services\QuestionService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function __construct(readonly private QuestionService $questionService)
    {
    }

    public function index(Request $request)
    {
        $faqs = $this->questionService->all($request->toArray());
        return ApiResponse::success(data:new QuestionCollection($faqs),message:'success');
    }
}
