<?php

namespace ZnCore\Base\Libs\I18Next\SymfonyTranslation;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use ZnCore\Base\Helpers\EnvHelper;
use ZnCore\Base\Libs\I18Next\Exceptions\NotFoundBundleException;
use ZnCore\Base\Libs\I18Next\Facades\I18Next;
use ZnCore\Base\Libs\I18Next\SymfonyTranslation\Helpers\TranslatorHelper;
use ZnCore\Domain\Helpers\EntityHelper;

class Translator implements TranslatorInterface
{

    private $bundleName;
    private $domain;
    private $logger;

    public function __construct(string $bundleName, string $domain = 'message', LoggerInterface $logger)
    {
        $this->bundleName = $bundleName;
        $this->domain = $domain;
        $this->logger = $logger;
    }

    public function trans(string $id, array $parameters = [], string $domain = null, string $locale = null)
    {
        $domain = $domain ?: $this->domain;
        
        $parametersI18Next = TranslatorHelper::paramsToI18Next($parameters);
        $id = TranslatorHelper::getSingularFromId($id);
        $key = $domain . '.' . TranslatorHelper::messageToHash($id);
        $translatedMessage = $this->translateMessage($key, $parametersI18Next);
        
        if($translatedMessage == null) {
            return strtr($id, $parameters);
        }
        return $translatedMessage;
    }
    
    private function translateMessage(string $key, array $parameters = []): ?string
    {
        try {
            $translatedMessage = I18Next::t($this->bundleName, $key, $parameters);
            if($translatedMessage == $key) {
                $this->logger->error('I18next no translation found! Not found key!', [
                    'bundle' => $this->bundleName,
                    'key' => $key,
                    'parameters' => $parameters,
                    'trace' => debug_backtrace(),
                ]);
            }
            if ($translatedMessage != $key || EnvHelper::isProd()) {
               // dd($translatedMessage, $key);
                return $translatedMessage;
            }

            return null;
        } catch (NotFoundBundleException $e) {
            $this->logger->error('I18next no translation found! Not found bundle!', [
                'bundle' => $this->bundleName,
                'key' => $key,
                'parameters' => $parameters,
            ]);
            return null;
        }
    }
}
