<?php

namespace App\Services;

use App\Repositories\AppointmentRepository;
use App\Models\Appointment;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AppointmentsService
{
    public function __construct(
        private AppointmentRepository $appointmentRepository
    ) {}

    public function getAllAppointments(): Collection
    {
        return $this->appointmentRepository->getAll();
    }

    public function getAppointmentById(int $id): Appointment
    {
        $appointment = $this->appointmentRepository->findById($id);

        if (!$appointment) {
            throw new NotFoundHttpException('Appointment not found');
        }

        return $appointment;
    }

    public function createAppointment(array $data): Appointment
    {
        return $this->appointmentRepository->create($data);
    }

    public function updateAppointment(int $id, array $data): Appointment
    {
        $appointment = $this->getAppointmentById($id);
        return $this->appointmentRepository->update($appointment, $data);
    }

    public function deleteAppointment(int $id): bool
    {
        $appointment = $this->getAppointmentById($id);
        return $this->appointmentRepository->delete($appointment);
    }
}
