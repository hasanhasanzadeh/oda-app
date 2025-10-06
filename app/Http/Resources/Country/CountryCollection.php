<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\File\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
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
            'countries' => $this->collection->map(function ($item) {
                return [
                    'country_id' => $item->id,
                    'country_name' => $item->country_name,
                    'country_persian_name' => $item->country_persian_name,
                    'country_code' => $item->country_code,
                    'flag' => $item->flag ? new FileResource($item->flag) : null,
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
