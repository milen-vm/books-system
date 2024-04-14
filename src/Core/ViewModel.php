<?php
namespace BooksSystem\Core;

abstract class ViewModel
{
    protected array $errors = [];
    
    public function getErrors($separator = false): array|string
    {
        if ($separator === false) {

            return $this->errors;
        }

        return implode($separator, $this->errors);
    }

    public function addError(string $error)
    {
        $this->errors[] = $error;
    }
}