<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BlogCollection extends ResourceCollection
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
        return [
            'blogs'=>$this->collection->map(function ($item){
                return [
                    'title'=>$item->title,
                    'slug'=>$item->slug,
//                    'description'=>$item->description,
                    'view_count'=>$item->view_count,
                    'writer'=> $item->author->full_name,
                    'image'=>$item->photo ? new FileResource($item->photo) : null ,
                    'video'=>$item->video_id ? new FileResource($item->video) : null ,
                    'created_at'=>verta($item->created_at)->formatDatetime(),
                ];
            }),
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
}
