<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Models\Book;

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
        if ($serObj = Session::pull('userBookModel')) {
            $model = unserialize($serObj);
        } else {
            $model = new Book();
        }

        $this->render(['model' => $model, 'label' => 'New Book']);
    }

    public function store_book()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('name', 'isbn', 'description');
        $book = new Book(...$params);

        if (!$book->validate()) {
            $serObj = serialize($book);
            Session::set('userBookModel', $serObj);

            $this->redirect('admin/create_book');
        }

        $book->save();

        $this->redirect('book/index');
    }

    public function edit_book($id)
    {
        $book = Book::getById($id);

        $this->render(
            [
                'model' => $book,
                'label' => 'Edit Book'
            ], 
        'admin.create_book');
    }
}