<?php
namespace BooksSystem\Controllers;
use BooksSystem\Core\Controller;

class HomeController extends Controller
{
    public function error()
    {
        return $this->render();
    }
}