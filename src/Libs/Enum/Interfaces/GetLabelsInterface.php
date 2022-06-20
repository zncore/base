<?php

namespace ZnCore\Base\Libs\Enum\Interfaces;

/**
 * Возможность получения названий констант
 * 
 * Используется в Enum-классах
 */
interface GetLabelsInterface
{

    /**
     * Получить массив названий
     * @return array
     */
    public static function getLabels();
}
