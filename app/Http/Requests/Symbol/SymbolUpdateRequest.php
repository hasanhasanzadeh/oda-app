<?php

namespace App\Http\Requests\Symbol;

use App\Models\Symbol;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SymbolUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('symbol-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return Symbol::rules([
            'title' => 'required|string|max:256|unique:symbols,title,' . $this->id,
            'image' => 'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:5048',
        ]);
    }
}
