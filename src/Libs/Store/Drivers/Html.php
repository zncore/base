<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;

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
        FileHelper::save($fileName, $content);
    }

    public function load($fileName, $key = null)
    {
        if ( ! FileHelper::has($fileName)) {
            return null;
        }
        $data = FileHelper::load($fileName);
        return $data;
    }

}