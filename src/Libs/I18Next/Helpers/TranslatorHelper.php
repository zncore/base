<?php

namespace ZnCore\Base\Libs\I18Next\Helpers;

class TranslatorHelper
{

    public static function processVariables(string $return, array $variables): string
    {
        foreach ($variables as $variable => $value) {
            if (is_string($value) || is_numeric($value)) {
                $return = preg_replace('/__' . $variable . '__/', $value, $return);
                $return = preg_replace('/{{' . $variable . '}}/', $value, $return);
            }
        }
        return $return;
    }

}
