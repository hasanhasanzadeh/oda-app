<?php

namespace App\Http\Resources\Meta;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource
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
            'meta_id' => $this->id,
            'meta_title'=> $this->meta_title,
            'meta_description'=> $this->meta_description,
            'meta_keywords'=> $this->meta_keywords,
        ];
    }
}
