<?php

namespace App\Http\Requests\Country;

use App\Models\Country;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use function Symfony\Component\Translation\t;

class CountryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('country-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Country::rules([
            'country_name'=>'required|string|min:2|max:70|unique:countries,country_name,'.$this->id,
            'country_code'=>'required|string|max:2|unique:countries,country_code,'.$this->id,
            'country_persian_name'=>'required|string|max:70|unique:countries,country_persian_name,'.$this->id,
            'flag'=>'nullable|image|mimes:png,jpg,webp,jpeg,gif,svg,bmp,avif|max:'. config('file-upload.max_file_upload'),
        ]);
    }
}
