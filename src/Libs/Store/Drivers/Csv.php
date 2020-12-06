<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Helpers\StringHelper;
use ZnCore\Base\Interfaces\EncoderInterface;

class Csv implements EncoderInterface
{

    public function decode($content)
    {
        $content = trim($content);
        $lines = StringHelper::textToLines($content);
        $data = array_map('str_getcsv', $lines);
        return $data;
    }

    public function encode($data)
    {
        $content = '';
        foreach ($data as $columns) {
            $line = implode(',', $columns);
            $content .= $line . PHP_EOL;
        }
        $content = trim($content);
        return $content;
    }
}
