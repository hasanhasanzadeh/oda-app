<?php

namespace App\Http\Resources\Payment;

use App\Helpers\Helper;
use App\Http\Resources\AvailableFlight\AvailableFlightResource;
use Illuminate\Http\Request;
use App\Http\Resources\File\FileResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaymentCollection extends ResourceCollection
{

    public function __construct($resource)
    {
        parent::__construct($resource);
    }
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'payments' => $this->collection->map(function ($item) {
                return [
                    'payment_id'=>$item->id,
                    'paymentable_id' => $item->paymentable_id ,
                    'paymentable_type' => $item->paymentable ,
                    'reference_id' => $item->reference_id ,
                    'transaction_id' => $item->transaction_id ,
                    'status' => $item->status ,
                    'amount' => number_format($item->amount,0) ,
                    'created_at' => verta($item->created_at)->formatDatetime() ,
                ];
            }),
            'pagination' => [
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
                'last_page' => $this->lastPage(),
                'from' => $this->firstItem(),
                'to' => $this->lastItem(),
            ],
        ];
    }
}
