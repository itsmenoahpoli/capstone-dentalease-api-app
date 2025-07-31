<?php

namespace App\Http\Requests\Appointments;

use Illuminate\Foundation\Http\FormRequest;

class StoreAppointmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'patient_name' => ['required', 'string', 'max:255'],
            'patient_email' => ['required', 'email', 'max:255'],
            'patient_contact' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string', 'max:1000'],
            'remarks' => ['nullable', 'string', 'max:1000'],
            'schedule_time' => ['required', 'date_format:H:i'],
            'schedule_date' => ['required', 'date', 'after_or_equal:today'],
            'status' => ['required', 'in:pending,active,past_due,cancelled'],
        ];
    }
}
