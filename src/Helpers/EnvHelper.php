<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;

class EnvHelper
{

    public static function isProd(): bool
    {
        return self::getAppEnv() != 'prod';
    }

    public static function getAppEnv(): ?string
    {
        return $_ENV['APP_ENV'] ?? null;
    }
}