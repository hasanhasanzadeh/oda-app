<?php

namespace App\Http\Requests\Setting;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SettingFindRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('setting-find');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'previous_url'=>'nullable|string',
            'favicon'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
            'logo'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ];
    }
}
