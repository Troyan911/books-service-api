<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'edition' => ['nullable', 'integer', 'min:1'],
            'published_at' => ['nullable', 'date'],
            'format' => ['nullable', 'string', 'max:50'],
            'pages' => ['nullable', 'integer', 'min:1'],
            'country' => ['nullable', 'string', 'max:100'],
            'isbn' => ['nullable', 'string', 'max:20', 'unique:books,isbn'],
            'publisher' => ['nullable', 'string'],
            'authors' => ['required', 'array', 'min:1'],
            'authors.*' => ['string'],
            'genres' => ['nullable', 'array'],
            'genres.*' => ['string'],
        ];
    }
}
