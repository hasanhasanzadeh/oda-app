<?php

namespace App\Http\Resources\Province;


use App\Http\Resources\City\CityCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProvinceResource extends JsonResource
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
            'cities'=>$this->cities ? new CityCollection($this->cities) : null,
        ];
    }
}
