<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\File\AvatarResource;
use App\Http\Resources\File\FileResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'father_name' => $this->father_name,
            'gender' => $this->gender,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'national_code' => $this->national_code,
            'address' => $this->address,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'referral_code' => $this->referral_code,
            'birthday' => verta($this->birthday),
            'created_at' => verta($this->created_at)->formatDatetime(),
            'created_at_day' => Carbon::parse($this->created_at)->diffInDays(),
            'avatar'=>$this->avatar ? new FileResource($this->avatar):new AvatarResource($this),
        ];
    }
}
