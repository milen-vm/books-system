<?php
namespace BooksSystem\Core;

abstract class ViewModel
{
    protected array $errors = [];
    
    public function getErrors($separator = false)
    {
        if ($separator === false) {

            return $this->errors;
        }

        return implode($separator, $this->errors);
    }
}