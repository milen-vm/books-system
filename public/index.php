<?php
require '../vendor/autoload.php';

\BooksSystem\Core\Session::start();
$request = \BooksSystem\Core\Request::getInstance();
$app = \BooksSystem\Core\App::getInstance();

$app->start($request);
