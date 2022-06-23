<?php

namespace ZnCore\Base\Store\Drivers;

use Symfony\Component\VarExporter\VarExporter;
use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\FileSystem\Helpers\FileStorageHelper;
use ZnCore\Base\Store\Helpers\FileGeneratorHelper;

use ZnCore\Base\Text\Helpers\TextHelper;

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
//        $content = VarDumper::export($data);
        $content = VarExporter::export($data);
        $content = TextHelper::setTab($content, 4);
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