<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\Store\StoreFile;

class LoadHelper
{

    public static function loadConfig($mainConfigFile = null)
    {
        $store = new StoreFile(__DIR__ . '/../../../../../' . $mainConfigFile);
        $config = $store->load();
        return $config;
    }

    public static function saveConfig($mainConfigFile = null, $data)
    {
        $store = new StoreFile(__DIR__ . '/../../../../../' . $mainConfigFile);
        $store->save($data);
    }

    public static function loadTemplate(string $fileName, array $params = []): string
    {
        ob_start();
        extract($params);
        include($fileName);
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }

    public static function loadScript(string $fileName)
    {
        return @include(FileHelper::path($fileName));
    }

    public static function loadConfigList(array $fileNames, array $config = []): array
    {
        foreach ($fileNames as $fileName) {
            $itemConfig = self::loadScript($fileName);
            if(is_array($itemConfig)) {
                $config = ArrayHelper::merge($config, $itemConfig);
            }
        }
        return $config;
    }

}