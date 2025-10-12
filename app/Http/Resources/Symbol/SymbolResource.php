<?php

namespace App\Http\Resources\Symbol;

use App\Http\Resources\File\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SymbolResource extends JsonResource
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
            'symbol_id' => $this->id,
            'url'=> $this->url,
            'title'=> $this->title,
            'status'=> $this->status,
            'type'=> $this->type,
            'description'=> $this->description,
            'image'=>$this->photo?new FileResource($this->photo): null,
        ];
    }
}
