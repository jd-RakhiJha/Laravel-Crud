<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadFileRequest extends FormRequest
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
    // public function rules(): array
    // {
    //     return [
    //         'file' => 'required|file|max:10240',
    //         'path' => 'sometimes|string|max:255'
    //     ];
    // }

    // public function messages()
    // {
    //     return [
    //         'file.required' => 'A file is required for upload',
    //         'file.file' => 'The uploaded item must be a file',
    //         'file.max' => 'The file size must not exceed 10MB',
    //         'path.max' => 'The path must not exceed 255 characters'
    //     ];
    // }
}
