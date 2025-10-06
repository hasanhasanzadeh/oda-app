<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContactCollection extends ResourceCollection
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
            'contacts' => $this->collection->map(function ($item) {
                return [
                    'contact_id' => $item->id,
                    'name' => $item->name,
                    'email' => $item->email,
                    'mobile'=> $item->mobile,
                    'ip_address' => $item->ip_address,
                    'message'=>$item->message,
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
