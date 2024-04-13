<?php
namespace BooksSystem\Core;

class App
{
    private static $instance = null;

    private $controller;

    private $controllerName;

    private $action;
    /**
     * @var \BooksSystem\Core\Request
     */
    private $request;

    private function __construct()
    {
    }

    public static function getInstance()    
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function start(Request $request)
    {
        $this->request = $request;

        $this->setController();
        $this->setAction();

        call_user_func_array([
            $this->controller,
            $this->action],
            $this->request->params()
        );
    }

    public function getControllerName()
    {
        return $this->controllerName;
    }

    private function setController()
    {
        if ($this->request->controller() === null) {
            $name = 'Home';
        } else {
            $name = $this->request->controller();
        }

        $this->controllerName = $name;
        $class = '\\BooksSystem\\Controllers\\' . ucfirst(strtolower($name)) . 'Controller';

        if (!class_exists($class)) {
            header('HTTP/1.1 400 Bad request', true, 400);
            echo '404';

            exit;
        }

        $this->controller = new $class();
    }

    public function getActionName()
    {
        return $this->action;
    }

    private function setAction()
    {
        if ($this->request->action() === null) {
            $action = 'index';
        } else {
            $action = strtolower($this->request->action());
        }

        if (!method_exists($this->controller, $action)) {
            header('HTTP/1.1 400 Bad request', true, 400);
            echo '404';

            exit;
        }

        $this->action = $action;
    }

    public static function csrfToken()
    {
        if (Session::isSetKey('csrfToken')) {

            return Session::get('csrfToken');
        }

        return self::resetCsrfToken();
    }

    public static function resetCsrfToken()
    {
        $token =  hash('sha256', uniqid());
        Session::set('csrfToken', $token);

        return $token;
    }

    public static function host()
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'];
    }
}
