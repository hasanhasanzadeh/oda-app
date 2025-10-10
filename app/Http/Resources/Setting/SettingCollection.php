<?php

namespace App\Http\Resources\Setting;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\SocialMedia\SocialMediaResource;
use App\Http\Resources\Symbol\ServiceCollection;
use App\Http\Resources\Symbol\SymbolCollection;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SettingCollection extends ResourceCollection
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
            'settings'=>$this->collection->map(function ($item){
                return [
                    'setting_id'=>$item->id,
                    'title'=>$item->title,
                    'url'=>$item->url,
                    'short_text'=>$item->short_text,
                    'copy_right'=>$item->copy_right,
                    'about'=>$item->about,
                    'email'=>$item->email,
                    'tel'=>$item->tel,
                    'phone'=>$item->phone,
                    'price'=>number_format($item->price,0),
                    'address'=>$item->address,
                    'medias' => $item->socialMedia?new SocialMediaResource($item->socialMedia):null,
                    'meta' => $item->meta?new MetaResource($item->meta):null,
                    'icon'=>$item->favicon_id?new FileResource($item->favicon):null,
                    'logo'=>$item->logo_id?new FileResource($item->logo):null,
                    'created_at'=>verta($item->created_at)->formatDatetime()
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
