<?php

namespace App\Services;

use App\Repositories\ContentDataRepository;
use App\Models\ContentData;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\ValidationException;

class ContentDataService
{
    public function __construct(
        private ContentDataRepository $contentDataRepository
    ) {}

    public function getAllContent(): Collection
    {
        return $this->contentDataRepository->getAllContent();
    }

    public function getContentById(int $id): ContentData
    {
        return $this->contentDataRepository->getContentById($id);
    }

    public function getContentByCategory(string $category): ?ContentData
    {
        return $this->contentDataRepository->getContentByCategory($category);
    }

    public function getAllContentByCategory(string $category): \Illuminate\Database\Eloquent\Collection
    {
        return $this->contentDataRepository->getAllContentByCategory($category);
    }

        public function createContent(array $data): ContentData
    {
        if ($data['category'] !== 'clinic_announcements') {
            $existingContent = $this->contentDataRepository->getContentByCategory($data['category']);

            if ($existingContent) {
                throw ValidationException::withMessages([
                    'category' => 'Content for this category already exists. Only one record per category is allowed.'
                ]);
            }
        }

        return $this->contentDataRepository->createContent($data);
    }

        public function updateContent(int $id, array $data): ContentData
    {
        $currentContent = $this->contentDataRepository->getContentById($id);

        if (isset($data['category']) && $data['category'] !== $currentContent->category) {
            if ($data['category'] !== 'clinic_announcements') {
                $existingContent = $this->contentDataRepository->getContentByCategory($data['category']);

                if ($existingContent) {
                    throw ValidationException::withMessages([
                        'category' => 'Content for this category already exists. Only one record per category is allowed.'
                    ]);
                }
            }
        }

        return $this->contentDataRepository->updateContent($id, $data);
    }

    public function deleteContent(int $id): bool
    {
        return $this->contentDataRepository->deleteContent($id);
    }

    public function getActiveContent(): Collection
    {
        return $this->contentDataRepository->getActiveContent();
    }
}
