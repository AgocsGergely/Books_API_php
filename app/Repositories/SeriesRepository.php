<?php
namespace App\Repositories;

class SeriesRepository extends BaseRepository
{
    public string $tableName = 'series';

    public function create(array $data): ?int
    {
        if (!isset($data['name'])) {
            throw new \Exception("SeriesRepository error: name is required.");
        }

        return parent::create($data);
    }
}
