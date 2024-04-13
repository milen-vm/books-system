<?php
namespace BooksSystem\Core;

class Session
{
    public static function start()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_name('books_system');
            ini_set('session.cookie_httponly', 1);
            session_start();
        }
    }

    public static function destroy()
    {
        $_SESSION = [];
        session_destroy();
        self::start();
    }

    public static function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }

        return null;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function isSetKey($key)
    {
        return isset($_SESSION[$key]);
    }

    public static function pull($key)
    {
        $val = null;
        if (isset($_SESSION[$key])) {
            $val = $_SESSION[$key];
            unset($_SESSION[$key]);
        }

        return $val;
    }
}