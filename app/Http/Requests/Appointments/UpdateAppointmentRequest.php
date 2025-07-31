<?php

namespace App\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => ['sometimes', 'required', 'string', 'max:255'],
            'patient_email' => ['sometimes', 'required', 'email', 'max:255'],
            'patient_contact' => ['sometimes', 'required', 'string', 'max:255'],
            'purpose' => ['sometimes', 'required', 'string', 'max:1000'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'schedule_time' => ['sometimes', 'required', 'date_format:H:i'],
            'schedule_date' => ['sometimes', 'required', 'date'],
            'status' => ['sometimes', 'required', 'in:pending,active,past_due,cancelled'],
        ];
    }
}
