<?php

namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;

class PatientRepository
{
    public function __construct(
        private Patient $patient
    ) {}

    public function getAll(): Collection
    {
        return $this->patient->orderBy('id', 'desc')->get();
    }

    public function findById(int $id): ?Patient
    {
        return $this->patient->find($id);
    }

    public function create(array $data): Patient
    {
        return $this->patient->create($data);
    }

    public function update(Patient $patient, array $data): Patient
    {
        $patient->update($data);
        return $patient->fresh();
    }

    public function delete(Patient $patient): bool
    {
        return $patient->delete();
    }
}
