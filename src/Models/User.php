<?php
namespace BooksSystem\Models;
use BooksSystem\Core\Model;

class User extends Model
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'users';
    }

    public function create($firstName, $lastName, $email, $password)
    {
        $id = $this->insert([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
        ]);

        return $id;
    }
}