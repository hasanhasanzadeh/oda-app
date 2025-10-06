<?php

namespace App\Http\Resources\SocialMedia;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SocialMediaCollection extends ResourceCollection
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
            'socialMedias' => $this->collection->map(function ($item) {
                return [
                    'social_media_id' => $item->id,
                    'telegram'=>$item->telegram,
                    'instagram'=>$item->instagram,
                    'facebook'=>$item->facebook,
                    'whatsapp'=>$item->whatsapp,
                    'youtube'=>$item->youtube,
                    'x_link'=>$item->x_link,
                    'linkedin'=>$item->linkedin,
                    'map_data'=>$item->map_data,
                    'google_plus'=>$item->google_plus,
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
