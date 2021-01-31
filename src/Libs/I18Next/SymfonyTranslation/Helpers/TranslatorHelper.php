<?php

namespace ZnCore\Base\Libs\I18Next\SymfonyTranslation\Helpers;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Domain\Helpers\EntityHelper;

class TranslatorHelper
{
    
    public static function messageToHash(string $message): string
    {
        $messageHash = $message;
        $messageHash = str_replace('.', '', $messageHash);
        return $messageHash;
    }
    
    public static function getSingularFromId(string $id): string
    {
        $key = TranslatorHelper::splitId($id);
        return $key['singular'];
    }

    public static function getPluralFromId(string $id): string
    {
        $key = TranslatorHelper::splitId($id);
        return $key['plural'];
    }
    
    public static function splitId(string $id): array
    {
        $ids = explode('|', $id);
        if (count($ids) == 1) {
            $key['singular'] = $ids[0];
            $key['plural'] = $ids[0];
        } else {
            $key['singular'] = $ids[0];
            $key['plural'] = $ids[1];
        }
        return $key;
    }

    public static function paramsToI18Next(array $parameters = []): array
    {
        if (empty($parameters)) {
            return [];
        }
        $params = [];
        foreach ($parameters as $parameterName => $parameterValue) {
            $parameterName = trim($parameterName, ' {}');
            $params[$parameterName] = $parameterValue;
        }
        return $params;
    }
}
