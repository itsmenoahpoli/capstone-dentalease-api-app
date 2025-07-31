<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppointmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'patient_name' => $this->patient_name,
            'patient_email' => $this->patient_email,
            'patient_contact' => $this->patient_contact,
            'purpose' => $this->purpose,
            'remarks' => $this->remarks,
            'schedule_time' => $this->schedule_time,
            'schedule_date' => $this->schedule_date,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
