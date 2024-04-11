<?php
namespace BooksSystem\Core;

class View
{
    private const DS = DIRECTORY_SEPARATOR;
    private const VIEWS_DIR = VIEWS_DIR;
    private const LAYOUT_DIR = 'layouts';
    private const LAYOUT_HEADER = 'header';
    private const LAYOUT_FOOTER = 'footer';
    private const LAYOUT_DEFAULT = 'default';
    private const FILE_EXTENSION = '.php';

    private static $app;
    private $model;
    private $path;
    private $layoutDir;

    public function __construct($model = null, $path = null)
    {
        self::$app = App::getInstance();
        $this->model = $model;
        $this->setPath($path);
        $this->layoutDir = self::VIEWS_DIR . self::LAYOUT_DIR . self::DS;
    }

    private function setPath($path)
    {
        if ($path === null) {
            $path = self::VIEWS_DIR . $this->getDefaultPath();
        } else {
            $path = str_replace('\\', self::DS, strtolower($path));
            $path = str_replace('/', self::DS, $path);
            $path = self::VIEWS_DIR . trim($path, self::DS)  . self::FILE_EXTENSION;

            if (!is_readable($path)) {
                throw new \Exception("Template file is not found in the path {$path}");
            }
        }

        $this->path = $path;
    }

    private function getDefaultPath()
    {
        $path = self::$app->getControllerName() . self::DS .
            self::$app->getActionName() . self::FILE_EXTENSION;

        return strtolower($path);
    }

    public function render($renderLayout = true, $layout = self::LAYOUT_DEFAULT)
    {
        ob_start();
        $model = $this->model;
        if ($renderLayout) {
            $header = $this->layoutDir . $layout . self::DS . self::LAYOUT_HEADER . self::FILE_EXTENSION;

            if (!is_readable($header)) {
                throw new \Exception('Header layout file not found.');
            }

            require_once $header;
        }

        require_once $this->path;

        if ($renderLayout) {
            $footer = $this->layoutDir . $layout . self::DS . self::LAYOUT_FOOTER . self::FILE_EXTENSION;

            if (!is_readable($header)) {
                throw new \Exception('Footer layout file not found.');
            }

            require_once $footer;
        }

        echo ob_get_clean();
    }
}