<?php
namespace App\Repositories;

class AuthorRepository extends BaseRepository
{
    public string $tableName = 'author';

    public function create(array $data): ?int
    {
        if (!isset($data['name'])) {
            throw new \Exception("AuthorRepository error: name is required.");
        }

        return parent::create($data);
    }
}
