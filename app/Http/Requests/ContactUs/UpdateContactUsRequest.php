<?php

namespace App\Http\Requests\ContactUs;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactUsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'subject' => ['sometimes', 'string', 'max:255'],
            'message' => ['sometimes', 'string', 'max:1000'],
            'status' => ['sometimes', 'in:pending,read,replied,closed'],
        ];
    }
}
