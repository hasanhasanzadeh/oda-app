<?php

namespace App\Http\Requests\Content;

use App\Models\Content;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ContentUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('content-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Content::rules([
            'title'=>'required|string|max:256|unique:pages,title,'.$this->id,
            'type'=>'required|string|in:contact-us,about-us,rules,privacy|unique:contents,type,'.$this->id,
            'previous_url'=>'nullable|string',
            'image'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ]);
    }
}
