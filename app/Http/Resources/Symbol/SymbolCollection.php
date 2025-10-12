<?php
namespace App\Http\Resources\Symbol;

use App\Http\Resources\File\FileResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SymbolCollection extends ResourceCollection
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
        $symbols = $this->collection->map(function ($item) {
            return [
                'symbol_id' => $item->id,
                'url' => $item->url,
                'title' => $item->title,
                'status' => $item->status,
                'type' => $item->type,
                'description' => $item->description,
                'image' => $item->photo ? new FileResource($item->photo) : null,
            ];
        });

        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            return [
                'symbols' => $symbols,
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
            'data' => $symbols,
        ];
    }
}
