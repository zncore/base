<?php

namespace ZnCore\Base\Libs\Format\Encoders;

use ZnCore\Contract\Encoder\Interfaces\EncoderInterface;

/**
 * Base64-сериализатор
 */
class Base64Encoder implements EncoderInterface
{

    public function encode($data)
    {
        return base64_encode($data);
    }

    public function decode($encodedData)
    {
        return base64_decode($encodedData);
    }
}