<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Models\Book;
use BooksSystem\Models\User;
use BooksSystem\ViewModels\LoginViewModel;

class UserController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->authActions('removeBook', 'add_book', 'books');
    }
    public function create()
    {
        if ($serObj = Session::pull('createUserModel')) {
            $model = unserialize($serObj);
        } else {
            $model = new User();
        }

        $this->render(compact('model'));
    }

    public function store()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('first_name', 'last_name', 'email', 'password');
        $user = new User(...$params);

        if (!$user->validate()) {
            $this->redirectWithSession('user/create', 'createUserModel', $user);
        }

        if (!$user->save()) {
            $this->redirect('home/error');
        }

        $this->redirect('user/login');
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
            $this->redirectWithSession('user/login', 'loginViewModel', $loginView);
        }

        $user = User::login(...$params);
        if ($user === false) {
            $loginView->addError('Invalid credentials.');

            $this->redirectWithSession('user/login', 'loginViewModel', $loginView);
        }

        Session::set('logedUser', serialize($user));
        Session::set('isAdmin', $user->isAdmin());

        $this->redirect('user/books');
    }

    public function books()
    {
        $this->auth();
        $user = $this->getLogedUser();
        $books = Book::byUser($user->getId());

        $this->render(compact('books'));
    }

    public function add_book($id)
    {
        $this->auth();
        $this->reqestMethod('POST');

        $book = Book::getById($id);
        $user = $this->getLogedUser();

        if (!$book || !$user) {
            $this->redirect('home/error');
        }

        if (!$user->addBook($book)) {
            $this->redirect('home/error');
        }

        $this->redirect('user/books');
    }

    public function removeBook($id)
    {
        $this->auth();
        $this->reqestMethod('POST');
    }

    public function logout()
    {
        $this->reqestMethod('POST');
        Session::destroy();

        $this->redirect('user/login');
    }
}