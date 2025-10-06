<?php

namespace App\Http\Resources\Question;

use App\Http\Resources\File\FileResource;
use App\Http\Resources\Meta\MetaResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question_id' => $this->id,
            'title' => $this->title,
            'status'=>$this->status,
            'description'=>$this->description,
        ];
    }
}
