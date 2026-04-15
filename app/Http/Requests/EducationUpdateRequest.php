<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EducationUpdateRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'institution_name' => 'required|string|max:255',
            'degree'           => 'required|string|max:255',
            'field_of_study'   => 'required|string|max:255',
            'grade_gpa'       => 'nullable|string|max:10',
            'start_at'        => 'required|string|max:255',
            'end_at'          => 'required|string|max:255',
        ];
    }
}
