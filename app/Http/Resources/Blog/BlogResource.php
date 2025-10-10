<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use App\Http\Resources\Tag\TagCollection;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
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
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'writer' => $this->author->full_name,
            'view_count' => $this->view_count,
            'tags' => $this->tags ? new TagCollection($this->tags) : null,
            'meta' => $this->meta ? new MetaResource($this->meta) : null,
            'image' => $this->photo ? new FileResource($this->photo) : null,
            'video' => $this->video_id ? new FileResource($this->video) : null,
            'created_at' => verta($this->created_at)->formatDatetime()
        ];
    }

}
