<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'keyword' => 'nullable|string',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'sources' => 'nullable|string', // comma-separated string
            'category' => 'nullable|string', // not supported in 'everything', optional handling
        ];
    }
}
