<?php

namespace App\Http\Resources\User;

use App\Http\Resources\File\AvatarResource;
use App\Http\Resources\File\FileResource;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'users'=>$this->collection->map(function ($item){
                return [
                    'user_id' => $item->id,
                    'first_name' => $item->first_name,
                    'last_name' => $item->last_name,
                    'role_type' => $item->role_type,
                    'gender' => $item->gender,
                    'email' => $item->email,
                    'mobile' => $item->mobile,
                    'national_code' => $item->national_code,
                    'is_active' => $this->is_active,
                    'address' => $item->address,
                    'email_verified_at' => $item->email_verified_at,
                    'mobile_verified_at' => $item->mobile_verified_at,
                    'referral_code' => $item->referral_code,
                    'birthday' => verta($item->birthday)->formatJalaliDate(),
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
