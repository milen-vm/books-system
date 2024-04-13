<?php
namespace BooksSystem\Core;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    protected function render($model, $path = null, $hasLayot = true)
    {
        $view = new View($model, $path);
        $view->render($hasLayot);
    }

    protected function redirect($path)
    {
        header('Location: ' . App::host() . '/' . $path);
        exit;
    }
}