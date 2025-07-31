<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique('patients', 'email')->ignore($this->route('id'))],
            'contact' => ['sometimes', 'string', 'max:255'],
            'address' => ['sometimes', 'string'],
            'gender' => ['sometimes', 'in:male,female,other'],
            'birthdate' => ['sometimes', 'date', 'before:today'],
            'citizenship' => ['sometimes', 'string', 'max:255'],
            'status' => ['sometimes', 'in:active,inactive'],
        ];
    }
}
