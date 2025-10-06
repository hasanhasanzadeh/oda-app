<?php

namespace App\Http\Resources\Transaction;


use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
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
            'transactionable_id'=>$this->transactionable_id,
            'type'=>$this->type,
            'status_type'=>$this->status_type,
            'status'=>$this->status,
            'amount'=>number_format($this->amount,0),
            'amount_duller'=>number_format($this->amount_duller,2),
            'create_at'=>($this->created_at)->formatDatetime(),
        ];
    }
}
