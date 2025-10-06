<?php

namespace App\Http\Resources\Content;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContentResource extends JsonResource
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
            'content_id' => $this->id,
            'title' => $this->title,
            'type' => $this->type,
            'description'=>$this->description,
            'status'=>$this->status,
            'image'=>$this->photo ? new FileResource($this->photo) : null,
            'meta'=>$this->meta?new MetaResource($this->meta): null,
        ];
    }
}
