<?php

namespace ZnCore\Base\Libs\I18Next\SymfonyTranslation;

use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;

class Translator implements TranslatorInterface
{

    private $bundleName;
    private $domain;

    public function __construct(string $bundleName, string $domain = 'message')
    {
        $this->bundleName = $bundleName;
        $this->domain = $domain;
    }

    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        $domain = $domain ?: $this->domain;
        $parametersI18Next = $this->paramsToI18Next($parameters);
        $translatedMessage = $this->translateMessage($domain, $id, $parametersI18Next);
        if($translatedMessage == null) {
            return strtr($id, $parameters);
        }
        return $translatedMessage;
    }

    private function paramsToI18Next(array $parameters = []): array
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

    private function messageToHash(string $message): string
    {
        $messageHash = $message;
        $messageHash = str_replace('.', '', $messageHash);
        return $messageHash;
    }

    private function translateMessage(string $domain, string $message, array $parameters = []): ?string
    {
        $key = $domain . '.' . $this->messageToHash($message);
        try {
            $translatedMessage = I18Next::t($this->bundleName, $key, $parameters);
            if ($translatedMessage != $key || EnvHelper::isProd()) {
                return $translatedMessage;
            }
            return null;
        } catch (NotFoundBundleException $e) {
            return null;
        }
    }
}
