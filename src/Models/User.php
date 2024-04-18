<?php
namespace BooksSystem\Models;

use BooksSystem\Core\Model;
use BooksSystem\Core\Repository;

class User extends Model
{
    private static Repository $repository;
    protected static string $table = 'users';

    public function __construct(
        protected ?string $first_name = null,
        protected ?string $last_name = null,
        protected ?string $email = null,
        protected ?string $password = null,
        protected ?bool $is_active = null,
        protected ?bool $is_admin = null,
        protected ?string $create_time = null
    ) {
        self::$repository = new Repository(self::$table);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getFirstName()
    {
        return $this->first_name;
    }

    public function getLastName()
    {
        return $this->last_name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function isActive()
    {
        return (bool) $this->is_active;
    }

    public function isAdmin()
    {
        return (bool) $this->is_admin;
    }

    public function getCreateTime()
    {
        return $this->create_time;
    }
    
    public static function getById($id): self
    {
        $data = (new Repository(self::$table))->find(['where' => 'id = ?'], [$id]);
        unset($data['id']);

        $self = new self(...$data);
        $self->id = $id;

        return $self;
    }

    protected function create(): bool
    {
        $id = self::$repository->insert([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => password_hash($this->password, PASSWORD_DEFAULT),
            'is_active' => 0,
            'is_admin' => 0
        ]);

        if (!$id) {
            return false;
        }

        $this->id = $id;

        return true;
    }

    protected function update(): bool
    {
        return self::$repository->update(
            ['where' => 'id = ?', 'values' => [$this->id]],
            [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'is_active' => ($this->is_active ? 1 : 0),
                'is_admin' => ($this->is_admin ? 1 : 0)
            ]
        );
    }

    public static function all(): array
    {
        $items = (new Repository(self::$table))->findAll(['orderby' => 'create_time DESC']);
        $users = [];
        foreach ($items as $item) {
            $id = $item['id'];
            unset($item['id']);

            $user = new self(...$item);
            $user->id = $id;
            $users[] = $user;
        }

        return $users;
    }

    public static function login($email, $password): bool|User
    {
        $ressult = (new Repository(self::$table))->find(['where' => 'email = ? and is_active = 1'], [$email]);
      
        if (count($ressult) == 0) {
        	return false;
        }

        if (password_verify($password, $ressult['password'])) {
            $id = $ressult['id'];

            unset($ressult['password']);
            unset($ressult['id']);

            $user = new self(...$ressult);
            $user->id = $id;

            return $user;
        }
        
        return false;
    }

    public function addBook(Book $book): bool
    {
        $booksUsers = new Repository('books_users');
        $pivot = $booksUsers->find(
            ['where' => 'user_id = ? and book_id = ?'],
            [$this->id, $book->getId()]
        );

        if (count($pivot) > 0) {
            return true;
        }

        $res = $booksUsers->insert([
            'user_id' => $this->id,
            'book_id' => $book->getId()
        ]);

        return (bool) $res;
    }

    public function validate(): bool
    {
        if (!trim($this->first_name)) {
            $this->errors[] = 'First name is required.';
        }

        if (!trim($this->last_name)) {
            $this->errors[] = 'Last name is required.';
        }

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