<?php

namespace App\Http\Requests\Schema;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSchemaRequest extends FormRequest
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
            'name' => 'required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama schema harus diisi.',
            'name.string' => 'Nama schema harus berupa string.',
            'name.max' => 'Nama schema maksimal 255 karakter.',
        ];
    }
}
