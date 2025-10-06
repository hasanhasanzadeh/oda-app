<?php

namespace App\Http\Resources\SocialMedia;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SocialMediaResource extends JsonResource
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
        return[
            'social_media' => $this->id,
            'telegram'=>$this->telegram,
            'instagram'=>$this->instagram,
            'facebook'=>$this->facebook,
            'whatsapp'=>$this->whatsapp,
            'youtube'=>$this->youtube,
            'x_link'=>$this->x_link,
            'linkedin'=>$this->linkedin,
            'map_data'=>$this->map_data,
            'google_plus'=>$this->google_plus,
        ];
    }
}
