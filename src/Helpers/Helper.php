<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Exceptions\ReadOnlyException;

/**
 * Универсальный хэлпер для разных задач
 */
class Helper
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

    /**
     * Проверка атрибута на запись
     * 
     * При запрете записи вызывает исключение.
     * @param $attribute
     * @param $value
     * @throws ReadOnlyException
     */
    public static function checkReadOnly($attribute, $value)
    {
        if (isset($attribute) && $attribute !== $value) {
            throw new ReadOnlyException('Content is read only!');
        }
    }
}
