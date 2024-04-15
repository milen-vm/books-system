<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Repositories\UserRepository;
use BooksSystem\ViewModels\LoginViewModel;
use BooksSystem\ViewModels\UserViewModel;

class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct()
    {
        parent::__construct();
        $this->userRepository = new UserRepository();
    }
    public function create()
    {
        if ($serObj = Session::pull('userViewModel')) {
            $model = unserialize($serObj);
        } else {
            $model = new UserViewModel();
        }

        $this->render(compact('model'));
    }

    public function store()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('firstName', 'lastName', 'email', 'password');
        $userView = new UserViewModel(...$params);

        if (!$userView->validate()) {
            $serObj = serialize($userView);
            Session::set('userViewModel', $serObj);

            $this->redirect('user/create');
        }

        $id = $this->userRepository->create(...$params);
        $user = $this->userRepository->login($params['email'], $params['password']);
        
        if ($user === false) {
            $this->redirect('home/error');
        }

        Session::set('logedUser', serialize($user));
        Session::set('isAdmin', $user->isAdmin());

        $this->redirect('user/books');
    }

    public function login()
    {
        if ($serObj = Session::pull('loginViewModel')) {
            $model = unserialize($serObj);
        } else {
            $model = new LoginViewModel();
        }

        $this->render(compact('model'));
    }

    public function login_user()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('email', 'password');
        $loginView = new LoginViewModel(...$params);

        if (!$loginView->validate()) {
            $serObj = serialize($loginView);
            Session::set('loginViewModel', $serObj);

            $this->redirect('user/login');
        }

        $user = $this->userRepository->login(...$params);
        if ($user === false) {
            $loginView->addError('Invalid credentials.');
            $serObj = serialize($loginView);
            Session::set('loginViewModel', $serObj);

            $this->redirect('user/login');
        }

        Session::set('logedUser', serialize($user));
        Session::set('isAdmin', $user->isAdmin());

        $this->redirect('user/books');
    }

    public function books()
    {
        if (!Session::isSetKey('logedUser')) {
            $this->redirect('user/login');
        }

        $this->render();
    }

    public function logout()
    {
        Session::destroy();

        $this->redirect('user/login');
    }
}