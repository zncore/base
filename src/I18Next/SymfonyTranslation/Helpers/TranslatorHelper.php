<?php

namespace ZnCore\Base\I18Next\SymfonyTranslation\Helpers;

class TranslatorHelper
{

    public static function messageToHash(string $message): string
    {
        $messageHash = $message;
        $messageHash = str_replace('.', '', $messageHash);
        return $messageHash;
    }

    public static function paramsToI18Next(array $parameters = []): array
    {
        if (empty($parameters)) {
            return [];
        }
        $params = [];
        foreach ($parameters as $parameterName => $parameterValue) {
            $parameterName = trim($parameterName, ' {}%');
            $params[$parameterName] = $parameterValue;
        }
        return $params;
    }
}
