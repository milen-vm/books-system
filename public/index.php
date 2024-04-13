<?php
require '../vendor/autoload.php';

\BooksSystem\Core\Session::start();
$request = \BooksSystem\Core\Request::getInstance();
$app = \BooksSystem\Core\App::getInstance();

$app->start($request);

// var_dump($request->controller());
// var_dump($request->action());
// var_dump($request->method());
// var_dump($request->params());