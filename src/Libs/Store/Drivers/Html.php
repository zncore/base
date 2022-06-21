<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;

class Html implements DriverInterface
{

    public function decode($code)
    {
        return $code;
    }

    public function encode($code)
    {
        return $code;
    }

    public function save($fileName, $data)
    {
        $content = $this->encode($data);
        FileStorageHelper::save($fileName, $content);
    }

    public function load($fileName, $key = null)
    {
        if (!FileStorageHelper::has($fileName)) {
            return null;
        }
        $data = FileStorageHelper::load($fileName);
        return $data;
    }
}