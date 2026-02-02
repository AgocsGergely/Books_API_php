<?php
namespace App\Repositories;

class PublisherRepository extends BaseRepository
{
    public string $tableName = 'publisher';

    public function create(array $data): ?int
    {
        if (!isset($data['name'])) {
            throw new \Exception("PublisherRepository error: name is required.");
        }

        return parent::create($data);
    }
}
