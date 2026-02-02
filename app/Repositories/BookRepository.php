<?php
namespace App\Repositories;

class BookRepository extends BaseRepository
{
    public string $tableName = 'books';

    public function create(array $data): ?int
    {
        if (!isset($data['id'])) {
            throw new \Exception("BookRepository error: id (ISBN) is required.");
        }

        if (!isset($data['author_id'])) {
            throw new \Exception("BookRepository error: author_id is required.");
        }

        return parent::create($data);
    }

    public function getById(string $id): ?array
    {
        $query = $this->select() . "WHERE id = '$id'";
        $result = $this->mysqli->query($query);
        return $result->fetch_assoc() ?: null;
    }

    public function getByAuthor(int $authorId): array
    {
        $query = $this->select() . "WHERE author_id = $authorId ORDER BY name";
        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }

    public function getByCategory(int $categoryId): array
    {
        $query = $this->select() . "WHERE category = $categoryId ORDER BY name";
        return $this->mysqli->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}
