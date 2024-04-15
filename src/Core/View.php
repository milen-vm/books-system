<?php
namespace BooksSystem\Core;

class View
{
    private const DS = DIRECTORY_SEPARATOR;

    private static $viewsDir = '';
    private static $app;
    private $variables;
    private $path;

    public function __construct($variables = [], $path = null)
    {
        self::$viewsDir = getcwd() . '/../src/views';
        self::$app = App::getInstance();

        $this->variables = $variables;
        $this->setPath($path);
    }

    private function setPath($path)
    {
        if ($path === null) {
            $path = self::$viewsDir . self::DS . $this->getDefaultPath();
        } else {
            $path = str_replace('.', self::DS, strtolower($path));
            $path = self::$viewsDir . self::DS . $path . '.php';

            if (!is_readable($path)) {
                throw new \Exception("Template file is not found in the path {$path}");
            }
        }

        $this->path = $path;
    }

    private function getDefaultPath()
    {
        $path = self::$app->getControllerName() . self::DS .
            self::$app->getActionName() . '.php';

        return strtolower($path);
    }

    public function render($renderLayout = true)
    {
        $host = self::$app::host();
        $hasUser = Session::isSetKey('logedUser');
        $isAdmin = $hasUser ? Session::get('isAdmin') : false;

        if ($renderLayout) {
            $layout = self::$viewsDir. self::DS . 'layout.php';

            if (!is_readable($layout) || !is_readable($this->path)) {
                throw new \Exception('Layout or view file not found.');
            }

            extract($this->variables);
            $path = $this->path;

            require_once $layout;
        } else {
            require_once $this->path;
        }
    }

    public static function encode($value)
    {
        if (is_null($value)) {
            echo $value;
        } else {
            echo htmlentities($value);
        }
    }
}