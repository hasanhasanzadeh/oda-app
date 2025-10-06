<?php

namespace App\Http\Resources\Country;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Province\ProvinceCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'country_id' => $this->id,
            'country_name' => $this->country_name,
            'country_code' => $this->country_code,
            'country_persian_name' => $this->country_persian_name,
            'flag' => $this->flag ? new FileResource($this->flag) : null,
            'provinces' => $this->provinces ? new ProvinceCollection($this->provinces) : null,
        ];
    }
}
