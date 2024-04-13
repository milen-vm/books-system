<?php
namespace BooksSystem\Controllers;
use BooksSystem\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        return $this->render();
    }

    public function error()
    {
        return $this->render();
    }
}