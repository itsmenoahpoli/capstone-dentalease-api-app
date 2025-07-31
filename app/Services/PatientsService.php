<?php

namespace App\Services;

use App\Repositories\PatientRepository;
use App\Models\Patient;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PatientsService
{
    public function __construct(
        private PatientRepository $patientRepository
    ) {}

    public function getAllPatients(): Collection
    {
        return $this->patientRepository->getAll();
    }

    public function getPatientById(int $id): Patient
    {
        $patient = $this->patientRepository->findById($id);

        if (!$patient) {
            throw new NotFoundHttpException('Patient not found');
        }

        return $patient;
    }

    public function createPatient(array $data): Patient
    {
        return $this->patientRepository->create($data);
    }

    public function updatePatient(int $id, array $data): Patient
    {
        $patient = $this->getPatientById($id);
        return $this->patientRepository->update($patient, $data);
    }

    public function deletePatient(int $id): bool
    {
        $patient = $this->getPatientById($id);
        return $this->patientRepository->delete($patient);
    }
}
