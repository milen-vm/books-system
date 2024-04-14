<?php
namespace BooksSystem\Repositories;

use BooksSystem\Core\Repository;
use BooksSystem\Models\Book;
use BooksSystem\Models\User;

class BookRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'books';
    }

    public function create($name, $isbn, $description)
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
        $items = $this->findAll(['orderby' => 'create_time DESC']);
        $books = [];

        foreach ($items as $item) {
            $books[] = new Book(...$item);
        }
        
        return $books;
    }
}