<?php

namespace App\Http\Resources\Country;

use Illuminate\Http\Request;
use App\Http\Resources\File\FileResource;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryWithoutProvinceResource extends JsonResource
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
            'country_persian_name' => $this->country_persian_name,
            'country_code'=> $this->country_code,
            'flag'=> $this->flag ? new FileResource($this->flag) : null,
        ];
    }
}
