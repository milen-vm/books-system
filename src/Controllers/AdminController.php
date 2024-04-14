<?php
namespace BooksSystem\Controllers;

use BooksSystem\Core\Controller;
use BooksSystem\Core\Session;
use BooksSystem\Repositories\BookRepository;
use BooksSystem\ViewModels\BookViewModel;

class AdminController extends Controller
{
    private BookRepository $bookRepository;

    public function __construct()
    {
        parent::__construct();

        if (!Session::get('isAdmin')) {
            $this->redirect('home/error');
        }

        $this->bookRepository = new BookRepository();
    }

    public function create_book()
    {
        if ($serObj = Session::pull('userBookModel')) {
            $bookView = unserialize($serObj);
        } else {
            $bookView = new BookViewModel();
        }

        $this->render($bookView);
    }

    public function store_book()
    {
        $this->reqestMethod('POST');

        $params = $this->request->postParams('name', 'isbn', 'description');
        $bookView = new BookViewModel(...$params);

        if (!$bookView->validate()) {
            $serObj = serialize($bookView);
            Session::set('userBookModel', $serObj);

            $this->redirect('admin/create_book');
        }

        $id = $this->bookRepository->create(...$params);

        $this->redirect('home/index');
    }
}