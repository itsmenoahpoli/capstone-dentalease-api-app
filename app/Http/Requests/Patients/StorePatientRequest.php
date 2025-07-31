<?php

namespace App\Http\Requests\Patients;

use Illuminate\Foundation\Http\FormRequest;

class StorePatientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:patients,email'],
            'contact' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'gender' => ['required', 'in:male,female,other'],
            'birthdate' => ['required', 'date', 'before:today'],
            'citizenship' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', 'in:active,inactive'],
        ];
    }
}
