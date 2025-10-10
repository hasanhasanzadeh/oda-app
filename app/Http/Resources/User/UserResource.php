<?php

namespace App\Http\Resources\User;

use App\Http\Resources\File\AvatarResource;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\Notification\NotificationCollection;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'role_type' => $this->role_type,
            'gender' => $this->gender,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'national_code' => $this->national_code,
            'is_active' => $this->is_active,
            'address' => $this->address,
            'email_verified_at' => $this->email_verified_at,
            'mobile_verified_at' => $this->mobile_verified_at,
            'birthday' => verta($this->birthday)->formatJalaliDate(),
            'created_at' => verta($this->created_at)->formatDatetime(),
            'created_at_day' => Carbon::parse($this->created_at)->diffInDays(),
            'avatar'=>$this->avatar ? new FileResource($this->avatar):new AvatarResource($this),
            'notifications'=>$this->notifications ? new NotificationCollection($this->notifications): null,
            'notification_count'=>$this->notifications()->count(),
        ];
    }
}
