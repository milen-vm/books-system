<?php
namespace BooksSystem\Models;

class Book
{
    public function __construct(
    private int $id,
    private string $name,
    private string $isbn,
    private string $description,
    private string $create_time
    ) {}

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
        return $this->isbn;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }
}