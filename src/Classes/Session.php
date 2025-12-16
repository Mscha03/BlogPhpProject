<?php

namespace App\Classes;

class Session
{
    public static function get ($name)
    {
        return $_SESSION[$name] ?? null;
    }

    public static function set ($name, $value): void
    {
        $_SESSION[$name] = $value;
    }

    public static function has ($name): bool
    {
        if (isset($_SESSION[$name])) {
            return true;
        } else {
            return false;
        }
    }

    public static function unset ($name): true
    {
        unset($_SESSION[$name]);
        return true;
    }

    public static function flush($name, $value = null)
    {
        if (self::has($name)) {
            $session = self::get($name);
            self::forget($name);
            return $session;
        } else {
            self::set($name, $value);
        }
    }

}