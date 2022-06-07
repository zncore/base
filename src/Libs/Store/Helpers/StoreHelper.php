<?php

namespace ZnCore\Base\Libs\Store\Helpers;

use ZnCore\Base\Libs\Store\StoreFile;

class StoreHelper
{

    public static function load($fileName = null, $key = null, $default = null, string $driver = null)
    {
        $store = new StoreFile($fileName, $driver);
        $data = $store->load($key);
        $data = $data !== null ? $data : $default;
        return $data;
    }

    public static function save($fileName = null, $data, string $driver = null): void
    {
        $store = new StoreFile($fileName, $driver);
        $store->save($data);
    }
}
