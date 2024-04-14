<?php
namespace BooksSystem\Repositories;

use BooksSystem\Core\Repository;
use BooksSystem\Models\User;

class UserRepository extends Repository
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

    public function login($email, $password)
    {
        $ressult = $this->find(['where' => 'email = ? and is_active = 1'], [$email]);
      
        if (count($ressult) == 0) {
        	return false;
        }

        if (password_verify($password, $ressult['password'])) {
            unset($ressult['password']);

            return new User(...$ressult);
        }
        
        return false;
    }
}