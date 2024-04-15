<?php
namespace BooksSystem\Models;

use BooksSystem\Core\Model;

use BooksSystem\Repositories\BookRepository;

class Book extends Model
{
    private static BookRepository $repository;

    private ?int $id = null;

    public function __construct(
        private ?string $name = null,
        private ?string $isbn = null,
        private ?string $description = null,
        private ?string $create_time = null
    ) {
        self::$repository = new BookRepository();
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
        $data = (new BookRepository())->getById($id);
        $id = $data['id'];
        unset($data['id']);

        $self = new self(...$data);
        $self->id = $id;

        return $self;
    }

    public static function all(): array
    {
        $items = (new BookRepository())->allBooks();
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

    public function save(array $props = []): bool
    {
        if ($props) {
            $this->setProps($props);
        }

        if (!$this->validate()) {
            return false;
        }

        if ($this->id) {
            return $this->update();
        }

        return $this->create();
    }

    private function update()
    {
        return true;
    }

    private function create()
    {
        $id = self::$repository->create($this->name, $this->isbn, $this->description);
        if (!$id) {
            return false;
        }

        $this->id = $id;
        $data = self::$repository->getById($id);
        $this->create_time = $data['create_time'];

        return true;
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