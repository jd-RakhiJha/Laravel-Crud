<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteFileRequest extends FormRequest
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
    // public function rules()
    // {
    //     return [
    //         'path' => 'required|string|max:255'
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         'path.required' => 'The file path is required',
    //         'path.string' => 'The path must be a string',
    //         'path.max' => 'The path must not exceed 255 characters'
    //     ];
    // }
}
