<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CategoryAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('category-all');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sort'=>'nullable|string',
            'per_page'=>'nullable|string',
            'direction'=>'nullable|string',
            'search'=>'nullable|string',
            'from_date'=>'nullable|date_format:Y-m-d',
            'to_date'=>'nullable|date_format:Y-m-d',
            'previous_url'=>'nullable|string',
        ];
    }
}
