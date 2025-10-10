<?php

namespace App\Http\Resources\City;

use App\Http\Resources\Auth\AuthorResource;
use App\Http\Resources\Province\ProvinceWithoutCityResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CityProvinceResource extends JsonResource
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
            'city_id' => $this->id,
            'name' => $this->name,
            'province' => $this->province_id ? new ProvinceWithoutCityResource($this->province) : null,
        ];
    }
}
