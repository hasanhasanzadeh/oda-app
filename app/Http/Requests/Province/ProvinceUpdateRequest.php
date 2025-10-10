<?php

namespace App\Http\Requests\Province;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProvinceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('province-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'country_id'=>'required|exists:countries,id',
            'province_name'=>'required|unique:provinces,id,'.$this->id,
            'previous_url'=>'nullable|string',
        ];
    }
}
