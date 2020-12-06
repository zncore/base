<?php

namespace ZnCore\Base\Libs\Store\Drivers;

use Symfony\Component\Yaml\Yaml as SymfonyYaml;
use ZnCore\Base\Interfaces\EncoderInterface;

class Yaml implements EncoderInterface
{

    public function decode($content)
    {

        $data = SymfonyYaml::parse($content);
        //$data = ArrayHelper::toArray($data);
        return $data;
    }

    public function encode($data)
    {
        $content = SymfonyYaml::dump($data, 10);
        //$content = str_replace('    ', "\t", $content);
        return $content;
    }

}