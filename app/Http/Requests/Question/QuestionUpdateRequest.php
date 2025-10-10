<?php

namespace App\Http\Requests\Question;

use App\Models\Qaq;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class QuestionUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('question-update');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return Qaq::rules([
            'title'=>'required|max:256|string|unique:questions,title,'.$this->id,
            'previous_url'=>'nullable|string',
        ]);
    }
}
