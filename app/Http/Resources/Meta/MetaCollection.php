<?php

namespace App\Http\Resources\Meta;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MetaCollection extends ResourceCollection
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
            'metas' => $this->collection->map(function ($item) {
                return [
                    'meta_id' => $item->id,
                    'meta_title'=> $item->meta_title,
                    'meta_description'=> $item->meta_description,
                    'meta_keywords'=> $item->meta_keywords,
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
