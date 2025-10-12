<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $products = $this->collection->map(function ($item) {
            return [
                'product_id' => $item->id,
                'name'=>$item->name,
                'slug'=>$item->slug,
                'category'=>new CategoryResource($item->category),
                'price'=>number_format($item->price,0),
                'original_price'=>number_format($item->original_price,0),
                'discount'=>$item->discount,
                'quantity'=>$item->quantity,
                'status'=>$item->status,
                'status_label'=>$item->status_label,
                'created_at' => verta($item->created_at)->formatDatetime(),
                'image' => $item->photo ? new FileResource($item->photo) : null,
            ];
        });

        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            return [
                'products' => $products,
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

        return [
            'data' => $products,
        ];
    }
}
