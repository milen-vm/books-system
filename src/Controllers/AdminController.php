<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Models\Book;
use BooksSystem\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        if (!Session::get('isAdmin')) {
            $this->redirect('home/error');
        }
    }

    public function create_book()
    {
        if ($serObj = Session::pull('storeBookModel')) {
            $model = unserialize($serObj);
        } else {
            $model = new Book();
        }

        $this->render(
            [
                'model' => $model,
                'label' => 'New Book',
                'action' => '/admin/store_book'
            ],
        'admin.book_form');
    }

    public function store_book()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('name', 'isbn', 'description');
        $book = new Book(...$params);

        if (!$book->validate()) {
            $serObj = serialize($book);
            Session::set('storeBookModel', $serObj);

            $this->redirect('admin/create_book');
        }

        if (!$book->save()) {
            $this->redirect('home/error');
        }

        $this->redirect('book/index');
    }

    public function edit_book($id)
    {
        if ($serObj = Session::pull('updateBookModel')) {
            $book = unserialize($serObj);
        } else {
            $book = Book::getById($id);
        }

        $this->render(
            [
                'model' => $book,
                'label' => 'Edit Book',
                'action' => '/admin/update_book/' . $book->getId(),
            ], 
        'admin.book_form');
    }

    public function update_book($id)
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('name', 'isbn', 'description');
        $book = Book::getById($id);
        $book->setProps($params);

        if (!$book->validate()) {
            $this->redirectWithSession('admin/edit_book/' . $id, 'updateBookModel', $book);
        }

        $book->save();

        $this->redirect('book/index');
    }

    public function users()
    {
        $users = User::all();

        $this->render(compact('users'));
    }

    public function toggle_active_user($userId)
    {
        $this->reqestMethod('POST');

        $user = User::getById($userId);
        $user->save(['is_active' => !$user->isActive()]);

        $this->redirect('admin/users');
    }

    public function toggle_admin_user($userId)
    {
        $this->reqestMethod('POST');

        $user = User::getById($userId);
        $user->save(['is_admin' => !$user->isAdmin()]);

        $this->redirect('admin/users');
    }
}