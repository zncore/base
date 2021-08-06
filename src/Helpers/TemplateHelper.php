<?php

namespace ZnCore\Base\Helpers;

class TemplateHelper
{

    public static function renderTemplate(string $mask, array $data = [], string $beginBlock = '{', string $endBlock = '}')
    {
        $newParams = [];
        foreach ($data as $name => $value) {
            $name = $beginBlock . $name . $endBlock;
            $newParams[$name] = $value;
        }
        return strtr($mask, $newParams);
    }

    public static function getVariableFromTemplate(string $content, string $beginBlock = '{', string $endBlock = '}'): array
    {
        preg_match_all('/'.$beginBlock.'([a-z-_.]+)'.$endBlock.'/i', $content, $matches);
        return $matches[1];
    }
}