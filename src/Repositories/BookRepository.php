<?php
namespace BooksSystem\Repositories;

use BooksSystem\Core\Repository;
use BooksSystem\Models\Book;

class BookRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'books';
    }

    public function create($name, $isbn, $description): int
    {
        $id = $this->insert([
            'name' => $name,
            'isbn' => $isbn,
            'description' => $description ?? null
        ]);

        return $id;
    }

    public function allBooks(): array
    {
        return $this->findAll(['orderby' => 'create_time DESC']);
    }

    public function getById($id): array
    {
        $result = $this->find(['where' => 'id = ?'], [$id]);

        return $result;
    }
}