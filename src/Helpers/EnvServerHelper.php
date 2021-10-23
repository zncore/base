<?php

namespace ZnCore\Base\Helpers;

class EnvServerHelper
{

    public static function isEqual(string $name)
    {
        return trim($_SERVER['REQUEST_URI'], '/') == trim($name, '/');
    }
    
    public static function find(string $name)
    {
        $isMatch = preg_match('/(\/' . $name . ')($|\/|\?)/', $_SERVER['REQUEST_URI'], $matches);
        return $isMatch ? $matches[1] : null;
    }

    public static function fix(string $name)
    {
        $_SERVER['SCRIPT_NAME'] = "/$name/index.php";
        $_SERVER['PHP_SELF'] = "/$name/index.php";
    }
}
