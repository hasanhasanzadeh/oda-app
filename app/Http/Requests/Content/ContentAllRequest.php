<?php

namespace App\Http\Requests\Content;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ContentAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('content-all');
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
        ];
    }
}
