<?php

namespace App\Repositories;

use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Collection;

class ContactUsRepository
{
    public function __construct(
        private ContactUs $contactUs
    ) {}

    public function getAll(): Collection
    {
        return $this->contactUs->orderBy('id', 'desc')->get();
    }

    public function findById(int $id): ?ContactUs
    {
        return $this->contactUs->find($id);
    }

    public function create(array $data): ContactUs
    {
        return $this->contactUs->create($data);
    }

    public function update(ContactUs $contactUs, array $data): ContactUs
    {
        $contactUs->update($data);
        return $contactUs->fresh();
    }

    public function delete(ContactUs $contactUs): bool
    {
        return $contactUs->delete();
    }
}
