<?php

namespace ZnCore\Base\Libs\Store\Helpers;

use ZnCore\Base\Libs\Store\StoreFile;

class StoreHelper
{

    public static function load($fileName = null)
    {
        $store = new StoreFile($fileName);
        return $store->load();
    }

    public static function save($fileName = null, $data): void
    {
        $store = new StoreFile($fileName);
        $store->save($data);
    }
}
