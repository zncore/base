<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Libs\Store\Helpers\StoreHelper;

/**
 * Загрузка и сохранение конфигураций
 * 
 * Поддерживаются следующие форматы файлов:
 * - Json
 * - Php
 * - Xml
 * - Yaml
 */
class LoadHelper
{

    /**
     * Загрузить конфиг
     * @param string $mainConfigFile Имя файла, относительно корня проекта
     * @return array|null
     */
    public static function loadConfig(string $mainConfigFile)
    {
        $rootDirectory = __DIR__ . '/../../../../..';
        return StoreHelper::load($rootDirectory . '/' . $mainConfigFile);
    }

    /**
     * Сохранить конфиг в файл
     * @param string $mainConfigFile Имя файла, относительно корня проекта
     * @param array $data Конфиг
     */
    public static function saveConfig(string $mainConfigFile, array $data)
    {
        $rootDirectory = __DIR__ . '/../../../../..';
        return StoreHelper::save($rootDirectory . '/' . $mainConfigFile, $data);
    }
}
