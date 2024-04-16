<?php
namespace BooksSystem\Models;

use BooksSystem\Core\Model;

use BooksSystem\Core\Repository;

class Book extends Model
{
    private static Repository $repository;
    protected static string $table = 'books';

    public function __construct(
        protected ?string $name = null,
        protected ?string $isbn = null,
        protected ?string $description = null,
        protected ?string $create_time = null
    ) {
        self::$repository = new Repository(self::$table);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getIsbn()
    {
        return $this->isbn;;
    }

    public function getDescription()
    {
        return $this->description;;
    }

    public function getCreateTime()
    {
        return $this->create_time;;
    }

    public static function getById($id): self
    {
        $data = (new Repository(self::$table))->find(['where' => 'id = ?'], [$id]);
        unset($data['id']);

        $self = new self(...$data);
        $self->id = $id;

        return $self;
    }

    public static function all(): array
    {
        $items = (new Repository(self::$table))->findAll(['orderby' => 'create_time DESC']);
        $books = [];
        foreach ($items as $item) {
            $id = $item['id'];
            unset($item['id']);

            $book = new self(...$item);
            $book->id = $id;
            $books[] = $book;
        }

        return $books;
    }

    protected function update(): bool
    {
        return self::$repository->update(
            ['where' => 'id = ?', 'values' => [$this->id]],
            [
                'name' => $this->name,
                'isbn' => $this->isbn,
                'description' => (empty($this->description) ? null : $this->description)
            ]
        );
    }

    protected function create(): bool
    {
        $id = self::$repository->insert(
            [
                'name' => $this->name,
                'isbn' => $this->isbn,
                'description' => (empty($this->description) ? null : $this->description)
            ]
        );

        if (!$id) {
            return false;
        }

        $this->id = $id;
        $data = self::$repository->find(['where' => 'id = ?'], [$id]);
        $this->create_time = $data['create_time'];

        return true;
    }

    public static function byUser($userId): array
    {
        $items = (new Repository(self::$table))->findAll(
            [
                'select' => 'books.*',
                'join' => ['books_users AS bu ON books.id = bu.book_id'],
                'where' => 'bu.user_id = ?',
                'orderby' => 'books.create_time DESC'
            ],
            [$userId]
        );

        $books = [];
        foreach ($items as $item) {
            $id = $item['id'];
            unset($item['id']);
            
            $book = new self(...$item);
            $book->id = $id;
            $books[] = $book;
        }

        return $books;
    }

    public function validate(): bool
    {
        if (!trim($this->name)) {
            $this->errors['name'] = 'Name is required.';
        }

        if (!trim($this->isbn)) {
            $this->errors['isbn'] = 'ISBN is required.';
        }

        return count($this->errors) === 0;
    }
}