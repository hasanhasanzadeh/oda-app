<?php
namespace App\Http\Resources\Tag;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
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
        $tags = $this->collection->map(function ($item) {
            return [
                'tag_id'=>$item->id,
                'name'=>$item->name,
            ];
        });

        // Check if resource is paginated
        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            return [
                'tags' => $tags,
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

        // If not paginated, omit pagination
        return [
            'tags' => $tags,
        ];
    }
}
