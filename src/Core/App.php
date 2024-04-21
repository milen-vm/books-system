<?php
namespace BooksSystem\Core;

class App
{
    private const DEFAULT_CONTROLER = 'book';
    private const DEFAULT_ACTION = 'index';
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
            $name = self::DEFAULT_CONTROLER;
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
            $action = self::DEFAULT_ACTION;
        } else {
            $action = $this->build($this->request->action(), '-');
        }

        if (!method_exists($this->controller, $action)) {
            header('HTTP/1.1 400 Bad request', true, 400);
            echo '404';

            exit;
        }

        $this->action = $action;
    }

    private function build(string $sting, string $sepparator): string
    {
        $parts = explode($sepparator, strtolower($sting));
        $str = array_shift($parts);

        while (count($parts) > 0) {
            $str .= ucfirst(array_shift($parts));
        }

        return $str;
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
