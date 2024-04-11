<?php
namespace BooksSystem\Core;

abstract class Controller
{
    public function render($params = [])
    {
        $arr = array_merge([
            'model' => null,
            'path' => null,
            'hasLayout' => true,
            'layout' => 'default',
        ], $params);

        $view = new View($arr['model'], $arr['path']);
        $view->render($arr['hasLayout'], $arr['layout']);
    }
}