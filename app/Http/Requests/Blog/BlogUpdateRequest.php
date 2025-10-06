<?php

namespace App\Http\Requests\Blog;

use App\Models\Blog;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BlogUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('blog-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return Blog::rules([
            'slug'=> 'required|string|min:2|unique:blogs,slug,'.$this->id,
            'image' => 'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:5048',
        ]);
    }
}
