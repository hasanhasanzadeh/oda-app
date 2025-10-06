<?php

namespace App\Http\Requests\Symbol;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SymbolAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('symbol-all');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
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
