<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
          'title' => ['required', 'string'],
          'author' => ['required', 'string'],
          'genre' => ['required', 'string'],
          'isbn' => ['required', 'string'],
          'published' => ['required', 'date'],
          'publisher' => ['required', 'string'],
          'description' => ['required', 'string'],
        ];
    }
}
