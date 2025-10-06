<?php

namespace App\Http\Resources\Contact;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
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
            'contact_id' => $this->id,
            'subject' => $this->subject,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'mobile'=> $this->mobile,
            'ip_address' => $this->ip_address,
            'message'=>$this->message,
        ];
    }
}
