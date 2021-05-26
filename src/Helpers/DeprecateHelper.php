<?php

namespace ZnCore\Base\Helpers;

use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;
use ZnCore\Base\Exceptions\DeprecatedException;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;

class DeprecateHelper
{

    private static $isStrictMode = false;

    public static function softThrow(string $message = '')
    {
        if (self::isStrictMode()) {
            throw new DeprecatedException('Deprecated: ' . $message);
        } else {
            //self::log($message);
        }
    }

    public static function hardThrow(string $message = '')
    {
        throw new DeprecatedException('Deprecated: ' . $message);
    }

    public static function isStrictMode(): bool
    {
        return self::getStrictMode() == true;
    }

    public static function setStrictMode()
    {
        self::$isStrictMode = true;
    }

    public static function getStrictMode()
    {
        return $_ENV['DEPRECATE_STRICT_MODE'] ?? self::$isStrictMode;
    }

    private static function log(string $message = '')
    {
        $container = ContainerHelper::getContainer();
        if (!$container instanceof ContainerInterface) {
            return;
        }
        if (!$container->has(LoggerInterface::class)) {
            return;
        }
        /** @var LoggerInterface $logger */
        $logger = $container->get(LoggerInterface::class);
        $noticeMessage = 'Deprecated functional';
        if ($message) {
            $noticeMessage .= ': ' . $message;
        }
        $logger->notice($noticeMessage, [
            'message' => $message,
        ]);
    }
}