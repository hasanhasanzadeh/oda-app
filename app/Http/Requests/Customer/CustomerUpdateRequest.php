<?php

namespace App\Http\Requests\Customer;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class CustomerUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('customer-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return User::rules([
            'national_code' => 'nullable|numeric|digits:10|unique:users,national_code,'.$this->id,
            'email' => 'nullable|email|max:100|unique:users,email,' . $this->id,
        ]);
    }
}
