<?php

namespace App\Http\Requests\Province;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ProvinceCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('province-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'country_id'=>'required|exists:countries,id',
            'province_name'=>'required|unique:provinces,id',
            'previous_url'=>'nullable|string',
        ];
    }
}
