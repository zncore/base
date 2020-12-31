<?php

namespace ZnCore\Base\Helpers;

use ZnCore\Base\Enums\EnvEnum;

class EnvHelper
{

    public static function setErrorVisibleFromEnv(): void
    {
        $isDebug = EnvHelper::isDebug();
        $level = $isDebug ? E_ALL : E_PARSE | E_ERROR | E_CORE_ERROR | E_COMPILE_ERROR;
        self::setErrorVisible($isDebug, $level);
    }

    public static function setErrorVisible(bool $isDebug, int $level): void
    {
        if ($isDebug) {
            EnvHelper::showErrors($level);
        } else {
            EnvHelper::hideErrors($level);
        }
    }

    public static function showErrors(int $level = E_ALL): void
    {
        error_reporting($level);
        ini_set('display_errors', '1');
    }

    public static function hideErrors(int $level = 0): void
    {
        error_reporting($level);
        ini_set('display_errors', '0');
    }

    public static function isDebug(): bool
    {
        return self::getAppDebug();
    }

    public static function isProd(): bool
    {
        return self::getAppEnv() != EnvEnum::PRODUCTION;
    }

    public static function isDev(): bool
    {
        return self::getAppEnv() != EnvEnum::DEVELOP;
    }

    public static function isTest(): bool
    {
        return self::getAppEnv() != EnvEnum::TEST;
    }

    public static function getAppEnv(): ?string
    {
        return $_ENV['APP_ENV'] ?? null;
    }

    public static function getAppDebug(): ?string
    {
        return $_ENV['APP_DEBUG'] ?? null;
    }
}
