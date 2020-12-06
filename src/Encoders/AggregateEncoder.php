<?php

namespace ZnCore\Base\Encoders;

use Illuminate\Support\Collection;
use ZnCore\Base\Interfaces\EncoderInterface;
use ZnCore\Base\Helpers\InstanceHelper;

class AggregateEncoder implements EncoderInterface
{

    private $encoderCollection;

    public function __construct(Collection $encoderCollection)
    {
        $this->encoderCollection = $encoderCollection;
    }

    public function getEncoders(): Collection
    {
        return $this->encoderCollection;
    }

    public function encode($data)
    {
        $encoders = $this->encoderCollection->all();
        foreach ($encoders as $encoderClass) {
            $encoderInstance = $this->getEncoderInstance($encoderClass);
            $data = $encoderInstance->encode($data);
        }
        return $data;
    }

    public function decode($data)
    {
        $encoders = $this->encoderCollection->all();
        $encoders = array_reverse($encoders);
        foreach ($encoders as $encoderClass) {
            $encoderInstance = $this->getEncoderInstance($encoderClass);
            $data = $encoderInstance->decode($data);
        }
        return $data;
    }

    private function getEncoderInstance($encoderClass): EncoderInterface
    {
        return InstanceHelper::ensure($encoderClass);
    }
}
