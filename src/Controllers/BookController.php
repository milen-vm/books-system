<?php
namespace BooksSystem\Controllers;
use BooksSystem\Core\Controller;
use BooksSystem\Models\Book;
use BooksSystem\Repositories\BookRepository;

class BookController extends Controller
{
    public function index()
    {
        $model = Book::all();

        $this->render(compact('model'));
    }
}