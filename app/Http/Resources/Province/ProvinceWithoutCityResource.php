<?php

namespace App\Http\Resources\Province;

use App\Http\Resources\Country\CountryWithoutProvinceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceWithoutCityResource extends JsonResource
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
            'province_id' => $this->id,
            'name'=>$this->name,
            'country'=>$this->country_id ? new CountryWithoutProvinceResource($this->country) : null ,
        ];
    }
}
