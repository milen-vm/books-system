<?php
namespace BooksSystem\Core;

class Request
{
    private static $instance = null;

    private $uri;
    private $controller;
    private $action;
    private $method;
    private $params = [];
    private $get = [];
    private $post = [];

    private function __construct()
    {
        $this->setUri();
        $this->parseUri();
        $this->setMethod();

        $this->get = $_GET;
        $this->post = $_POST;

        $this->validateCsrfToken();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function setUri()
    {
        $request = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $this->uri = trim($request, '/');
    }

    private function setMethod()
    {
        $this->method = $_SERVER['REQUEST_METHOD'];
    }

    private function parseUri()
    {
        $parts = [];
        if ($this->uri) {
            $parts = explode('/', $this->uri);

            if (array_search('', $parts) !== false) {
                $parts = array_filter($parts, function ($val) {
                    return $val !== '';
                });
            }
        }

        if (count($parts)) {
            $this->controller = array_shift($parts);

            if (count($parts)) {
                $this->action = array_shift($parts);
            }
        }

        $this->params = $parts;
    }

    private function validateCsrfToken()
    {
        if ($this->method !== 'POST') {

            return;
        }

        $postToken = $this->postParam('_csrf');
        $appToken = App::csrfToken();

        if ($postToken !== $appToken) {
            header('HTTP/1.1 400 Bad request', true, 400);
            header('Location: ' . App::host() . '/home/error');

            exit;
        }

        App::resetCsrfToken();
    }

    public function postParams(...$keys): array
    {
        $result = [];
        foreach ($keys as $key) {
            $result[$key] = $this->postParam($key);
        }

        return $result;
    }

    public function postParam($key): ?string
    {
        if (isset($this->post[$key])) {

            return $this->post[$key];
        }

        return null;
    }

    public function controller()
    {
        return $this->controller;
    }

    public function action()
    {
        return $this->action;
    }

    public function method()
    {
        return $this->method;
    }

    public function params()
    {
        return $this->params;
    }
}