<?php

namespace ZnCore\Base\Libs\ReadOnly\Helpers;

use ZnCore\Base\Libs\ReadOnly\Exceptions\ReadOnlyException;

class ReadOnlyHelper
{

    /**
     * Проверка атрибута на запись
     * 
     * При запрете записи вызывает исключение.
     * @param $attribute
     * @param $value
     * @throws ReadOnlyException
     */
    public static function checkAttribute($attribute, $value)
    {
        if (isset($attribute) && $attribute !== $value) {
            throw new ReadOnlyException('Content is read only!');
        }
    }
}
