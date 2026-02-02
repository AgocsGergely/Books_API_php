<?php
namespace App\Repositories;

class CityRepository extends BaseRepository
{
    public string $tableName = 'cities';

    public function create(array $data): ?int
    {
        if (!isset($data['county_id'])) {
            throw new \Exception("CityRepository error: county_id is required.");
        }

        return parent::create($data);
    }

    public function getByCounty(int $countyId): array
    {
        $query = $this->select() . "WHERE id_county = $countyId ORDER BY name";
        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}