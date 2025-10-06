<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class QuestionCollection extends ResourceCollection
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
            'questions' => $this->collection->map(function ($item) {
                return [
                    'question_id' => $item->id,
                    'title' => $item->title,
                    'status'=>$item->status,
                    'description'=>$item->description,
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
