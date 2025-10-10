<?php

namespace App\Http\Resources\City;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
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
            'cities' => $this->collection->map(function ($item) {
                return [
                    'city_id' => $item->id,
                    'name' => $item->name,
                    'province_id' => $item->province_id,
                    'province_name' => $item->province->name,
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
