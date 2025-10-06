<?php
namespace App\Http\Resources\Like;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class LikeCollection extends ResourceCollection
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
        $likes = $this->collection->map(function ($item) {
            return [
                'like_id' => $item->id,
//                'product' => new ProductResource($item->product),
            ];
        });

        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            return [
                'likes' => $likes,
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
            'data' => $likes,
        ];
    }
}
