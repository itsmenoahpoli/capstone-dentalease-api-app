<?php

namespace App\Repositories;

use App\Models\ContentData;
use Illuminate\Database\Eloquent\Collection;

class ContentDataRepository
{
    public function getAllContent(): Collection
    {
        return ContentData::all();
    }

    public function getContentById(int $id): ContentData
    {
        return ContentData::findOrFail($id);
    }

    public function getContentByCategory(string $category): ?ContentData
    {
        return ContentData::where('category', $category)->first();
    }

    public function createContent(array $data): ContentData
    {
        return ContentData::create($data);
    }

    public function updateContent(int $id, array $data): ContentData
    {
        $content = $this->getContentById($id);
        $content->update($data);
        return $content;
    }

    public function deleteContent(int $id): bool
    {
        $content = $this->getContentById($id);
        return $content->delete();
    }

    public function getActiveContent(): Collection
    {
        return ContentData::where('is_active', true)->get();
    }
}
