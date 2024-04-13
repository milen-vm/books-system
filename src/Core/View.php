<?php
namespace BooksSystem\Core;

class View
{
    private const DS = DIRECTORY_SEPARATOR;

    private static $viewsDir = '';
    private static $app;
    private $model;
    private $path;

    public function __construct($model = null, $path = null)
    {
        self::$viewsDir = getcwd() . '/../src/views';
        self::$app = App::getInstance();

        $this->model = $model;
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
        $host = App::host();

        if ($renderLayout) {
            $layout = self::$viewsDir. self::DS . 'layout.php';

            if (!is_readable($layout)) {
                throw new \Exception('Layout file not found.');
            }

            $content = $this->renderContent($this->path, $this->model);

            require_once $layout;
        } else {
            require_once $this->path;
        }
    }

    private function renderContent($paht, $model)
    {
        if (!is_readable($paht)) {
            throw new \Exception('View file not found.');
        }

        ob_start();
        require_once $paht;
        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}