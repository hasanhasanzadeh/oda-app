<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\File\AvatarResource;
use App\Http\Resources\File\FileResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CustomerCollection extends ResourceCollection
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
            'customers' => $this->collection->map(function ($item) {
                return [
                    'id' => $item->id,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'father_name' => $item->father_name,
                    'gender' => $item->gender,
                    'email' => $item->email,
                    'mobile' => $item->mobile,
                    'national_code' => $item->national_code,
                    'address' => $item->address,
                    'email_verified_at' => $item->email_verified_at,
                    'mobile_verified_at' => $item->mobile_verified_at,
                    'referral_code' => $item->referral_code,
                    'birthday' => verta($item->birthday),
                    'created_at' => verta($item->created_at)->formatDatetime(),
                    'created_at_day' => Carbon::parse($item->created_at)->diffInDays(),
                    'avatar'=>$item->avatar ? new FileResource($item->avatar):new AvatarResource($item),
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
