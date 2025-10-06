<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'service_id' => $this->id,
            'title' => $this->title,
            'link' => $this->link,
            'description'=>$this->description,
            'status'=>$this->status,
            'image'=>$this->photo ? new FileResource($this->photo) : null,
        ];
    }
}
