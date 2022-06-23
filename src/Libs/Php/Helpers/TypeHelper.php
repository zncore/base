<?php

namespace ZnCore\Base\Libs\Php\Helpers;

/**
 * Работа с типами данных
 */
class TypeHelper
{

    /**
     * Является ли значение бинарным
     * @param $str
     * @return bool
     */
    public static function isBinary($str): bool
    {
        //return preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
        return !ctype_print($str);
    }

    public static function isSha1($string)
    {
        return preg_match('/[0-9a-f]{40}/i', $string);
    }

    public static function isCallable($value)
    {
        return $value instanceof \Closure || is_callable($value);
    }
}
