<?php

namespace App\Repositories;

use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;

class AppointmentRepository
{
    public function __construct(
        private Appointment $appointment
    ) {}

    public function getAll(): Collection
    {
        return $this->appointment->orderBy('id', 'desc')->get();
    }

    public function findById(int $id): ?Appointment
    {
        return $this->appointment->find($id);
    }

    public function create(array $data): Appointment
    {
        return $this->appointment->create($data);
    }

    public function update(Appointment $appointment, array $data): Appointment
    {
        $appointment->update($data);
        return $appointment->fresh();
    }

    public function delete(Appointment $appointment): bool
    {
        return $appointment->delete();
    }
}
