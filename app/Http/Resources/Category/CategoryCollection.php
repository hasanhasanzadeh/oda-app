<?php

namespace App\Http\Resources\Category;

use App\Http\Resources\File\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
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
            'categories'=>$this->collection->map(function ($item){
                return [
                    'category_id'=>$item->id,
                    'name'=>$item->name,
                    'slug'=>$item->slug,
                    'image'=>$item->photo ? new FileResource($item->photo): null ,
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
