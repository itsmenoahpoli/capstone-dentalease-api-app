<?php

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;

class ServiceRepository
{
    public function __construct(
        private Service $service
    ) {}

    public function getAll(): Collection
    {
        return $this->service->all();
    }

    public function findById(int $id): ?Service
    {
        return $this->service->find($id);
    }

    public function create(array $data): Service
    {
        return $this->service->create($data);
    }

    public function update(Service $service, array $data): Service
    {
        $service->update($data);
        return $service->fresh();
    }

    public function delete(Service $service): bool
    {
        return $service->delete();
    }
}
