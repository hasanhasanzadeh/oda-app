<?php

namespace App\Http\Resources\Notification;

use App\Http\Resources\Category\CategoryResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class NotificationCollection extends ResourceCollection
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
        $notifications = $this->collection->map(function ($item) {
            return [
                'notification_id'=>$item->id,
                'title'=>$item->title,
                'description'=>$item->description,
                'status'=>$item->status,
                'created_at_dif'=>verta(verta($item->created_at))->formatDifference(),
                'created_at'=>verta($item->created_at)->formatDatetime()
            ];
        });

        if ($this->resource instanceof \Illuminate\Pagination\AbstractPaginator) {
            return [
                'notifications' => $notifications,
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
            'data' => $notifications,
        ];
    }
}
