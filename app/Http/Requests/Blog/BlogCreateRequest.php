<?php

namespace App\Http\Requests\Blog;

use App\Models\Blog;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BlogCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('blog-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return  Blog::rules([
            'previous_url'=>'nullable|string',
            'image'=>'required|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
            'video'=>'nullable|file|mimes:mp4|max:'. config('file-upload.max_video_upload'),
        ]);
    }
}
