<?php

namespace App\Http\Resources\Payment;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'payment_id'=>$this->id,
            'paymentable_id' => $this->paymentable_id ,
            'paymentable_type' => $this->paymentable ,
            'reference_id' => $this->reference_id ,
            'transaction_id' => $this->transaction_id ,
            'status' => $this->status ,
            'amount' => number_format($this->amount,0) ,
            'created_at' => verta($this->created_at)->formatDatetime() ,
        ];
    }
}
