<?php

namespace ZnCore\Base\Libs\Shell\Helpers;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Shell\CommandForm;

class CommandHelper
{

    private static $optionGlue = '=';

    public static function getCommandString(CommandForm $commandForm): string
    {
        $args = $commandForm->getArguments();
        if ($commandForm->getCommand()) {
            array_unshift($args, $commandForm->getCommand());
//            $args = ArrayHelper::merge([$commandForm->getCommand()], $args);
        }
        return self::argsToString($args, $commandForm->getLang());
    }

    public static function argsToString(array $args, string $langCode = null): string
    {
        $commandName = array_shift($args);
        $langOption = self::generateLang($langCode);
        $arguments = self::generateCommand($args);
        $command = "{$langOption} {$commandName} {$arguments}";
        return trim($command);
    }

    protected static function generateCommand(array $args): string
    {
        $args = self::processCommandArgs($args);
        return implode(' ', $args);
    }

    protected static function generateLang(?string $lang = null): string
    {
        if ($lang) {
            return 'LANG=' . $lang;
        }
        return '';
    }

    protected static function escapeshellarg($arg): string
    {
        if (is_bool($arg)) {
            $arg = intval($arg);
        }
        if (is_int($arg)) {
            return strval($arg);
        }
        return escapeshellarg($arg);
    }

    protected static function cleanEmptyArgs(array $args)
    {
        foreach ($args as $key => $value) {
            if (empty($value)) {
                if (is_string($key) && !empty($key)) {
                    $args[$key] = false;
                } else {
                    unset($args[$key]);
                }
            }
        }
        return $args;
    }

    protected static function processCommandArg($key, $value)
    {
        $cmd = '';
        if (is_string($key)) {
            $cmd = $key . self::$optionGlue;
        }
        return $cmd . self::escapeshellarg($value);
    }

    protected static function processCommandArgs(array $args)
    {
        $args = self::cleanEmptyArgs($args);
        $cmdArr = [];
        foreach ($args as $key => $value) {
            $cmdArr[] = self::processCommandArg($key, $value);
        }
        return $cmdArr;
    }

}
