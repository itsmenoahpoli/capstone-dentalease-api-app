<?php

namespace App\Http\Requests\Services;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category' => ['sometimes', 'string', 'max:255'],
            'name' => ['sometimes', 'string', 'max:255'],
            'price' => ['sometimes', 'numeric', 'min:0'],
            'status' => ['sometimes', 'in:offered,draft'],
        ];
    }
}
