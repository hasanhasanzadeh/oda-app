<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\PaymentAllRequest;
use App\Http\Requests\Payment\PaymentFindRequest;
use App\Models\Payment;
use App\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(readonly private PaymentService $paymentService)
    {
    }

    public function index(PaymentAllRequest $request)
    {
        $title = __('message.blogs');
        $validated = $request->validated();
        $payments = $this->paymentService->all($validated);
        session(['previous_url' => url()->full()]);
        return view('admin.payment.index', [
            'title' => $title,
            'payments' => $payments,
            'sort' => $validated['sort'] ?? 'created_at',
            'direction' => $validated['direction'] ?? 'desc',
            'perPage' => $validated['per_page'] ?? 10,
            'allowedPerPage' => [10, 25, 50, 100]
        ]);
    }

    public function show(PaymentFindRequest $request, $id)
    {
        $title = __('message.show');
        $payment = $this->paymentService->find($id);
        return view('admin.payment.show', compact(['title', 'payment']));
    }
}
