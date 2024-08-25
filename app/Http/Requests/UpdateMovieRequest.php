<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMovieRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'director' => 'sometimes|string|max:255',
            'genre' => 'sometimes|array',
            'genre.*' => 'sometimes|string|max:100',
            'release_year' => 'sometimes|integer|digits:4|min:1888|max:' . date('Y'),
            'description' => 'sometimes|string',
        ];
    }
}
