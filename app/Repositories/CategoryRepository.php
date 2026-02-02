<?php
namespace App\Repositories;

class CategoryRepository extends BaseRepository
{
    public string $tableName = 'category';

    public function create(array $data): ?int
    {
        if (!isset($data['name'])) {
            throw new \Exception("CategoryRepository error: name is required.");
        }

        return parent::create($data);
    }
}
