<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;

class UserController extends Controller
{
    public function create()
    {
        return $this->render();
    }

    public function store()
    {
        // TODO make csrf token
    }
}