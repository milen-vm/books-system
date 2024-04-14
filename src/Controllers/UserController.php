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
            $userView = unserialize($serObj);
        } else {
            $userView = new UserViewModel();
        }

        $this->render($userView);
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
            $loginView = unserialize($serObj);
        } else {
            $loginView = new LoginViewModel();
        }

        $this->render($loginView);
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

        $user = (new UserRepository())->login(...$params);
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