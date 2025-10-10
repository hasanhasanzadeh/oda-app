<?php

namespace App\Http\Requests\Product;

use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProductUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('product-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return Product::rules([
            'name'=> 'required|string|min:2|unique:products,name,'.$this->id,
            'slug'=> 'required|string|min:2|unique:products,slug,'.$this->id,
            'previous_url'=>'nullable|string',
            'image'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
            'gallery'=>'nullable|array',
            'gallery.*'=>'image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ]);
    }
}
