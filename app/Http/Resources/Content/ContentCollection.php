<?php

namespace App\Http\Resources\Content;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ContentCollection extends ResourceCollection
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
            'contents' => $this->collection->map(function ($item) {
                return [
                    'content_id' => $item->id,
                    'title' => $item->title,
                    'type' => $item->type,
                    'description'=>$item->description,
                    'status'=>$item->status,
                    'image'=>$item->photo ? new FileResource($item->photo) : null,
                    'meta'=>$item->meta?new MetaResource($item->meta): null,
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
