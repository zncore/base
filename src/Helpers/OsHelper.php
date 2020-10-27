<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Enums\OsFamilyEnum;

class OsHelper
{

    public static function isFamily(string $family): bool
    {
        return self::osFamily() == $family;
    }

    public static function osFamily()
    {
        if ('\\' === DIRECTORY_SEPARATOR) {
            return 'Windows';
        }

        $map = array(
            'Darwin' => OsFamilyEnum::DARWIN,
            'DragonFly' => OsFamilyEnum::BSD,
            'FreeBSD' => OsFamilyEnum::BSD,
            'NetBSD' => OsFamilyEnum::BSD,
            'OpenBSD' => OsFamilyEnum::BSD,
            'Linux' => OsFamilyEnum::LINUX,
            'SunOS' => OsFamilyEnum::SOLARIS,
        );

        return isset($map[PHP_OS]) ? $map[PHP_OS] : 'Unknown';
    }

}