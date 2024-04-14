<?php
namespace BooksSystem\ViewModels;

use BooksSystem\Core\ViewModel;

class LoginViewModel extends ViewModel
{
    public function __construct(
        private string $email = '',
        private string $password = ''
    ) {}

    public function getEmail()
    {
        return $this->email;
    }

    public function validate(): bool
    {
        if (!trim($this->email)) {
            $this->errors[] = 'Email is required.';
        } else 
        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email is not valid.';
        }

        if (!trim($this->password)) {
            $this->errors[] = 'Password is required.';
        }

        return count($this->errors) === 0;
    }
}