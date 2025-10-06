<?php

namespace App\Http\Resources\Transaction;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TransactionCollection extends ResourceCollection
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
            'transactions' => $this->collection->map(function ($item) {
                return [
                    'transactionable_id'=>$item->transactionable_id,
                    'type'=>$item->type,
                    'status_type'=>$item->status_type,
                    'status'=>$item->status,
                    'amount'=>number_format($item->amount,0),
                    'amount_duller'=>number_format($item->amount_duller,2),
                    'create_at'=>($item->created_at)->formatDatetime(),
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
