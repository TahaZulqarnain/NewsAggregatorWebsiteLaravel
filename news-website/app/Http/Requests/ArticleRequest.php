<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'search'    => ['nullable', 'string'],
            'source'    => ['nullable', 'string'],
            'author'    => ['nullable', 'string'],
            'category'  => ['nullable', 'string'],
            'from'      => ['nullable', 'date'],
            'to'        => ['nullable', 'date'],
            'page'      => ['nullable', 'integer', 'min:1'],
            'per_page'  => ['nullable', 'integer', 'between:1,100'],
        ];
    }
}
