<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Models\User;
use BooksSystem\ViewModels\UserViewModel;

class UserController extends Controller
{
    public function create()
    {
        if ($serObj = Session::pull('userViewModel')) {
            $userView = unserialize($serObj);
        } else {
            $userView = new UserViewModel();
        }

        return $this->render($userView);
    }

    public function store()
    {
        $params = $this->request->postParams('firstName', 'lastName', 'email', 'password');
        $userView = new UserViewModel(...$params);

        if (!$userView->validate()) {
            $serObj = serialize($userView);
            Session::set('userViewModel', $serObj);

            $this->redirect('user/create');
        }

        $id = (new User())->create(...$params);
    }
}