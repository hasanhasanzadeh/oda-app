<?php

namespace App\Http\Resources\Setting;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\SocialMedia\SocialMediaResource;
use App\Http\Resources\Symbol\SymbolCollection;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SettingResource extends JsonResource
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
            'setting_id'=>$this->id,
            'title'=>$this->title,
            'url'=>$this->url,
            'copy_right'=>$this->copy_right,
            'short_text'=>$this->short_text,
            'about'=>$this->about,
            'address'=>$this->address,
            'tel'=>$this->tel,
            'phone'=>$this->phone,
            'price'=>number_format($this->price,0),
            'email'=>$this->email,
            'icon'=>$this->favicon_id?new FileResource($this->favicon):null,
            'logo'=>$this->logo_id?new FileResource($this->logo): null,
            'medias' => $this->socialMedia?new SocialMediaResource($this->socialMedia):null,
            'meta' => $this->meta?new MetaResource($this->meta):null,
            'created_at'=>verta($this->created_at)->formatDatetime()
        ];
    }
}
