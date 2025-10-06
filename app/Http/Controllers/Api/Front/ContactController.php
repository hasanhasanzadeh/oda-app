<?php

namespace App\Http\Controllers\Api\Front;

use App\Helpers\ApiResponse;
use App\Http\ApiRequests\Contact\ContactCreateApiRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactResource;
use App\Services\ContactService;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(readonly private ContactService $contactService)
    {
    }

    public function store(ContactCreateApiRequest $request): JsonResponse
    {
        $contact = $this->contactService->create($request->validated());
        if ($contact) {
            return ApiResponse::success(new ContactResource($contact));
        }
        return ApiResponse::error(message: 'error', status: 500, errors: [
            'مشکل در ثبت اطلاعات لطفا بعد از مدتی دباره تلاش کنید'
        ]);
    }
}
