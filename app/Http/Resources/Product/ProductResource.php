<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\File\FileCollection;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'product_id' => $this->id,
            'name'=>$this->name,
            'name_en'=>$this->name_en,
            'slug'=>$this->slug,
            'description'=>$this->description,
            'price'=>number_format($this->price,0),
            'original_price'=>number_format($this->original_price,0),
            'discount'=>$this->discount,
            'quantity'=>$this->quantity,
            'sku'=>$this->sku,
            'status'=>$this->status,
            'status_label'=>$this->status_label,
            'category'=> new CategoryResource($this->category),
            'meta'=>$this->meta ? new MetaResource($this->meta) : null,
            'image' => $this->photo ? new FileResource($this->photo) : null,
            'gallery' => $this->gallery ? new FileCollection($this->gallery) : null,
            'created_at' => verta($this->created_at)->formatDatetime(),
        ];
    }
}
