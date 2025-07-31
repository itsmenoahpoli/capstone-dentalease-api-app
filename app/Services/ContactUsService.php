<?php

namespace App\Services;

use App\Repositories\ContactUsRepository;
use App\Models\ContactUs;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContactUsService
{
    public function __construct(
        private ContactUsRepository $contactUsRepository
    ) {}

    public function getAllContactUs(): Collection
    {
        return $this->contactUsRepository->getAll();
    }

    public function getContactUsById(int $id): ContactUs
    {
        $contactUs = $this->contactUsRepository->findById($id);

        if (!$contactUs) {
            throw new NotFoundHttpException('Contact us entry not found');
        }

        return $contactUs;
    }

    public function createContactUs(array $data): ContactUs
    {
        return $this->contactUsRepository->create($data);
    }

    public function updateContactUs(int $id, array $data): ContactUs
    {
        $contactUs = $this->getContactUsById($id);
        return $this->contactUsRepository->update($contactUs, $data);
    }

    public function deleteContactUs(int $id): bool
    {
        $contactUs = $this->getContactUsById($id);
        return $this->contactUsRepository->delete($contactUs);
    }
}
