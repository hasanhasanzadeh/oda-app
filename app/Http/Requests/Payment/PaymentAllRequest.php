<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PaymentAllRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('payment-all');
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
            'role_type'=>'nullable|string',
            'previous_url'=>'nullable|string',
        ];
    }
}
