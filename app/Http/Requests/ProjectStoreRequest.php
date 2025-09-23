<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'project_title' => 'string',
            'description' => 'string',
            'github_url' => 'nullable|string',
            'project_url' => 'nullable|string',
            'image' => 'nullable|mimes:jpg,png|max:2048'
        ];
    }
}
