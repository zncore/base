<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Interfaces\EncoderInterface;

class Serialize implements EncoderInterface
{

    public function decode($content)
    {
        $data = unserialize($content);
        //$data = ArrayHelper::toArray($data);
        return $data;
    }

    public function encode($data)
    {
        $content = serialize($data);
        return $content;
    }

}