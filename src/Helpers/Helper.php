<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Exceptions\ReadOnlyException;

class Helper
{

    public static function isBinary($str)
    {
        //return preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
        return !ctype_print($str);
    }

    public static function checkReadOnly($attribute, $value)
    {
        if (isset($attribute) && $attribute !== $value) {
            throw new ReadOnlyException('Content is read only!');
        }
    }

    public static function idsToArray($param)
    {
        if (empty($param)) {
            return [];
        }
        if (!is_array($param)) {
            $param = explode(',', $param);
        }
        $param = array_map('trim', $param);
        //$param = array_map('intval', $param);
        //$param = array_map(function(){}, $param);
        return $param;
    }
}
