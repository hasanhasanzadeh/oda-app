<?php

namespace App\Http\Requests\Service;

use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class ServiceUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('service-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Service::rules([
            'previous_url'=>'nullable|string',
            'image'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ]);
    }
}
