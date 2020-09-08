<?php

namespace ZnCore\Base\Libs\I18Next\Interfaces\Services;

interface TranslationServiceInterface
{

    public function getLanguage(): string;

    public function setLanguage(string $language, string $fallback = null);

    public function t(string $bundleName, string $key, array $variables = []);

    public function addBundle(string $bundleName, string $bundlePath);

}
