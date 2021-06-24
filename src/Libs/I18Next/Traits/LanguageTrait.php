<?php

namespace ZnCore\Base\Libs\I18Next\Traits;

use ZnCore\Base\Libs\I18Next\Enums\LanguageI18nEnum;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;

trait LanguageTrait
{

    protected $_language = "ru";

    public function __construct(RuntimeLanguageServiceInterface $languageService)
    {
        $this->_language = $languageService->getLanguage();
    }

    protected function i18n(string $attribute): string
    {
        $name = $attribute . 'I18n';
        if (!empty($this->$name)) {
            $translations = !is_array($this->$name) ? json_decode($this->$name) : $this->$name;
            $currentLanguage = LanguageI18nEnum::encode($this->_language);
            if (isset($translations[$currentLanguage])) {
                return $translations[$currentLanguage];
            }
        }
        return $this->$attribute;
    }

}