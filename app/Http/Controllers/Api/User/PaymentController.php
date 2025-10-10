<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\Advertisement\AdvertisementUserResource;
use App\Http\Resources\Payment\PaymentCollection;
use App\Http\Resources\Payment\PaymentResource;
use App\Models\Advertisement;
use App\Models\Payment;
use App\Models\Setting;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Shetabit\Payment\Facade\Payment as ShetabitPayment;

class PaymentController extends Controller
{

    public function __construct(readonly private PaymentService $paymentService)
    {
    }

    public function all(Request $request)
    {
        $request['me']=true;
        $payments = $this->paymentService->all($request->toArray());
        return ApiResponse::success(data:new PaymentCollection($payments),message:'success');
    }

    public function show($id)
    {
        $request['me']=true;
        $advertisement = $this->paymentService->find($id,$request['me']);
        return ApiResponse::success(data:new PaymentResource($advertisement),message:'success');
    }

    public function pay(Request $request)
    {
        $request->validate([
            'advertisement_id' => 'required|integer',
        ]);

        $advertisement = Advertisement::findOrFail($request->advertisement_id);
        $setting = Setting::firstOrFail();

        $request['amount'] = $setting->price;
        if ($setting->price==0 || $advertisement->status!='pending') {
            return ApiResponse::error(message: 'error', status: 404, errors: [
                'اگهی مورد نظر قابل پرداخت نمی باشد'
            ]);
        }
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'amount' => $request->amount,
            'status' => 'pending',
            'paymentable_id' => $request->advertisement_id,
            'paymentable_type' => $request->advertisement_id ? 'App\\Models\\Advertisement' : null,
        ]);

        $paymentUrl = ShetabitPayment::callbackUrl(route('payment.callback'))
            ->purchase(
                (new \Shetabit\Multipay\Invoice)->amount($payment->amount),
                function($driver, $transactionId) use ($payment) {
                    $payment->update([
                        'transaction_id' => $transactionId
                    ]);
                }
            )->pay();
        return ApiResponse::success(
            data: [
                'advertisement' => $advertisement ? new AdvertisementUserResource($advertisement) : null,
                'payment_url' => $paymentUrl??null,
            ],
            message: 'success',
            status: 201
        );
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('transaction_id', $request->Authority)->first();

        if (! $payment) {
            return ApiResponse::error(message: 'error', status: 404, errors: [
                'پرداخت مورد نظر یافت نشد لطفا دباره تلاش کنید'
            ]);
        }

        try {
            $receipt = ShetabitPayment::amount($payment->amount)->transactionId($request->Authority)->verify();

            $payment->update([
                'status' => 'done',
                'transaction_result' => json_encode($receipt),
                'reference_id' => $receipt->getReferenceId()
            ]);

            $advertisement = Advertisement::find($payment->paymentable_id);
            $advertisement->status = 'accepted';
            $advertisement->save();

            $redirectUrl = url(config('pay-redirect.redirect')).'?payment_id='.$payment->paymentable_id.'&status=done';
            return redirect($redirectUrl);

        } catch (\Exception $e) {

            $payment->update([
                'status' => 'failed',
                'transaction_result' => $e->getMessage(),
            ]);
            $redirectUrl = url(config('pay-redirect.redirect')).'?payment_id='.$payment->paymentable_id??'null'.'&status=failed';
            return redirect($redirectUrl);
        }
    }
}
