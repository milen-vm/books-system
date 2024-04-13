<?php
namespace BooksSystem\ViewModels;

use BooksSystem\Core\ViewModel;

class UserViewModel extends ViewModel
{
    public function __construct(
        private string $firstName = '',
        private string $lastName = '',
        private string $email = '',
        private string $password = ''
    ) {}

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function validate(): bool
    {
        if (!trim($this->firstName)) {
            $this->errors[] = 'First name is required.';
        }

        if (!trim($this->lastName)) {
            $this->errors[] = 'Last name is required.';
        }

        if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            $this->errors[] = 'Email is not valid.';
        }

        if (!trim($this->password)) {
            $this->errors[] = 'Password is required.';
        }

        return count($this->errors) === 0;
    }
}