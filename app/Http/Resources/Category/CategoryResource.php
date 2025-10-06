<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'category_id'=>$this->id,
            'name'=>$this->name,
            'slug'=>$this->slug,
            'meta'=>$this->meta ?new MetaResource($this->meta):null,
            'image'=>$this->photo ? new FileResource($this->photo): null,
        ];
    }
}
