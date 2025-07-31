<?php

namespace App\Services;

use App\Repositories\ServiceRepository;
use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ServicesService
{
    public function __construct(
        private ServiceRepository $serviceRepository
    ) {}

    public function getAllServices(): Collection
    {
        return $this->serviceRepository->getAll();
    }

    public function getServiceById(int $id): Service
    {
        $service = $this->serviceRepository->findById($id);

        if (!$service) {
            throw new NotFoundHttpException('Service not found');
        }

        return $service;
    }

    public function createService(array $data): Service
    {
        return $this->serviceRepository->create($data);
    }

    public function updateService(int $id, array $data): Service
    {
        $service = $this->getServiceById($id);
        return $this->serviceRepository->update($service, $data);
    }

    public function deleteService(int $id): bool
    {
        $service = $this->getServiceById($id);
        return $this->serviceRepository->delete($service);
    }
}
