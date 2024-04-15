<?php
namespace BooksSystem\Core;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    protected function render($variables = [], $path = null, $hasLayot = true)
    {

        $hasUser = Session::isSetKey('logedUser');
        $variables['hasUser'] = $hasUser;
        $variables['isAdmin'] = $hasUser ? Session::get('isAdmin') : false;

        $view = new View($variables, $path);
        $view->render($hasLayot);
    }

    protected function redirect($path)
    {
        header('Location: ' . App::host() . '/' . $path);
        exit;
    }

    protected function reqestMethod(string $method)
    {
        if ($this->request->method() !== $method) {
            $this->redirect('home/error');
        }
    }
}