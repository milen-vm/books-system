<?php
namespace BooksSystem\Models;

class User
{
    public function __construct(
    private int $id,
    private string $first_name,
    private string $last_name,
    private string $email,
    private bool $is_active,
    private bool $is_admin,
    private string $create_time
    ) {}

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

    public function email()
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
}