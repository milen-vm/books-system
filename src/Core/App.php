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
        // self::$configs = $config;

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
            throw new \Exception("Controller '{$name}' does not exists.");
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
            throw new \Exception('The method ' . $action .' in class '
                . get_class($this->controller) . ' does not exists.');
        }

        $this->action = $action;
    }
}

