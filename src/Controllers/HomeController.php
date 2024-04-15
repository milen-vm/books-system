<?php
namespace BooksSystem\Controllers;
use BooksSystem\Core\Controller;
use BooksSystem\Repositories\BookRepository;

class HomeController extends Controller
{
    public function error()
    {
        return $this->render();
    }
}