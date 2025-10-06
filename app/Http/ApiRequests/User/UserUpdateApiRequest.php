<?php

namespace App\Http\ApiRequests\User;

use App\Helpers\ApiResponse;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserUpdateApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return[
            'first_name' => 'nullable|string|min:3|max:70',
            'last_name' => 'nullable|string|min:3|max:70',
            'national_code' => 'nullable|numeric|ir_national_id|digits:10,unique:users,national_code,'.$this->id,
            'gender'=>'required|string|in:male,female',
            'email'=>'nullable|string|email|max:255|unique:users,email,'.$this->id,
            'birthday'=>'nullable|date_format:Y-m-d',
            'address'=>'nullable|string|min:3|max:255',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     * @throws HttpResponseException
     */
    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(
            ApiResponse::error(
                message: __('message.invalid_parameters'),
                status: 422,
                errors: collect($validator->errors()->all())->values()->toArray()
            )
        );
    }
}
