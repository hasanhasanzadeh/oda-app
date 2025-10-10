<?php

namespace App\Http\Requests\Setting;

use App\Models\Setting;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class SettingCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('setting-create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return Setting::rules([
            'previous_url'=>'nullable|string',
            'favicon'=>'required|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
            'logo'=>'required|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ]);
    }
}
