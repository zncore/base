<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

abstract class BaseEncoderDriver implements DriverInterface
{

    private $encoder;

    protected function setEncoder(EncoderInterface $encoder): void
    {
        $this->encoder = $encoder;
    }

    public function decode($content)
    {
        return $this->encoder->decode($content);
    }

    public function encode($data)
    {
        return $this->encoder->encode($data);
    }
}