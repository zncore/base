<?php

namespace ZnCore\Base\Enum\Interfaces;

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
