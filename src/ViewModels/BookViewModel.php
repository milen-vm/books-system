<?php
namespace BooksSystem\ViewModels;

use BooksSystem\Core\ViewModel;

class BookViewModel extends ViewModel
{
    public function __construct(
        private string $name = '',
        private string $isbn = '',
        private string $description = ''
    ) {}

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

    public function validate(): bool
    {
        if (!trim($this->name)) {
            $this->errors[] = 'Name is required.';
        }

        if (!trim($this->isbn)) {
            $this->errors[] = 'ISBN is required.';
        }

        return count($this->errors) === 0;
    }
}