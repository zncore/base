<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Base\Libs\Format\Encoders\XmlEncoder;

class Xml extends BaseEncoderDriver implements DriverInterface
{

    public function __construct()
    {
        $encoder = new XmlEncoder(true, 'UTF-8', false);
        $this->setEncoder($encoder);
    }
}