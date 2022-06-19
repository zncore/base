<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Exceptions\ReadOnlyException;

/**
 * Универсальный хэлпер для разных задач
 */
class Helper
{

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
