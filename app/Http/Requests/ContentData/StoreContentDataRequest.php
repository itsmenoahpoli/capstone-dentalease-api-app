<?php

namespace App\Http\Requests\ContentData;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\ContentData;

class StoreContentDataRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['required', 'string', 'in:' . implode(',', array_keys(ContentData::CATEGORIES))],
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string'],
            'metadata' => ['nullable', 'array'],
            'is_active' => ['boolean']
        ];
    }

    public function messages(): array
    {
        return [
            'category.in' => 'The category must be one of: ' . implode(', ', array_keys(ContentData::CATEGORIES)),
            'title.required' => 'The title field is required.',
            'content.required' => 'The content field is required.',
        ];
    }
}
