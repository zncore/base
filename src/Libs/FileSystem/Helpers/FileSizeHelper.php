<?php

namespace ZnCore\Base\Libs\FileSystem\Helpers;

use ZnCore\Base\Enums\Measure\ByteEnum;
use ZnCore\Base\Libs\Enum\Helpers\EnumHelper;

class FileSizeHelper
{

    public static function sizeUnit(int $sizeByte)
    {
        $units = ByteEnum::allUnits();
        foreach ($units as $name => $value) {
            if ($sizeByte / $value < ByteEnum::STEP) {
                return $value;
            }
        }
    }

    public static function sizeFormat(int $sizeByte, $precision = 2)
    {
        $unitKey = self::sizeUnit($sizeByte);
        $value = round($sizeByte / $unitKey, 2);
        $label = EnumHelper::getLabel(ByteEnum::class, $unitKey);
        return $value . ' ' . $label;
    }
}
