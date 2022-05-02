<?php

namespace ZnCore\Base\Encoders;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

class HexEncoder implements EncoderInterface
{

    public function encode($data)
    {
        return bin2hex($data);
    }

    public function decode($encodedData)
    {
        return hex2bin($encodedData);
    }
}