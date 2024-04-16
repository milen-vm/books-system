<?php
namespace BooksSystem\Core;

use BooksSystem\Models\User;

abstract class Controller
{
    protected Request $request;

    public function __construct()
    {
        $this->request = Request::getInstance();
    }

    protected function render(array $variables = [], string $path = null, bool $hasLayot = true)
    {

        $hasUser = Session::isSetKey('logedUser');
        $variables['hasUser'] = $hasUser;
        $variables['isAdmin'] = $hasUser ? Session::get('isAdmin') : false;

        $view = new View($variables, $path);
        $view->render($hasLayot);
    }

    protected function redirect(string $path)
    {
        header('Location: ' . App::host() . '/' . $path);
        exit;
    }

    protected function redirectWithSession(string $path, string $key, $data)
    {
        $serData = serialize($data);
        Session::set($key, $serData);

        $this->redirect($path);
    }

    protected function reqestMethod(string $method)
    {
        if ($this->request->method() !== $method) {
            $this->redirect('home/error');
        }
    }

    protected function auth()
    {
        if (!Session::isSetKey('logedUser')) {
            $this->redirect('user/login');
        }
    }

    protected function getLogedUser(): null|User
    {
        $data = Session::get('logedUser');
        if (!$data) {
            return null;
        }

        return unserialize($data);
    }
}