<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Libs\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Libs\Store\Helpers\FileGeneratorHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Legacy\Yii\Helpers\VarDumper;
use ZnCore\Base\Helpers\StringHelper;

class Php implements DriverInterface
{

    public function decode($content)
    {
        $code = '$data = ' . $content . ';';
        eval($code);
        /** @var mixed $data */
        return $data;
    }

    public function encode($data)
    {
        $content = VarDumper::export($data);
        $content = StringHelper::setTab($content, 4);
        return $content;
    }

    public function save($fileName, $data)
    {
        $content = $this->encode($data);
        $code = PHP_EOL . PHP_EOL . 'return ' . $content . ';';
        FileStorageHelper::save($fileName, $code);
        $data['fileName'] = $fileName;
        $data['code'] = $code;
        FileGeneratorHelper::generate($data);
    }

    public function load($fileName, $key = null)
    {
        if ( ! FileStorageHelper::has($fileName)) {
            return null;
        }
        $data = include($fileName);
        if ($key !== null) {
            return ArrayHelper::getValue($data, $key);
        }
        return $data;
    }

}