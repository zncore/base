<?php

namespace ZnCore\Base\Libs\I18Next\Traits;

use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\I18Next\Enums\LanguageI18nEnum;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;

trait LanguageTrait
{

    protected $_language = "ru";

    protected function setRuntimeLanguageService(RuntimeLanguageServiceInterface $languageService) {
        $this->_language = $languageService->getLanguage();
    }
    
    protected function i18n(string $attribute): ?string
    {
        $name = $attribute . 'I18n';
        if (!empty($this->$name)) {
            $translations = !is_array($this->$name) ? json_decode($this->$name, JSON_OBJECT_AS_ARRAY) : $this->$name;
            $currentLanguage = LanguageI18nEnum::encode($this->_language);
            $result = ArrayHelper::getValue($translations, $currentLanguage);
            if(empty($result)) {
                foreach ($translations as $code => $translation) {
                    if(trim($translation) != '') {
                        return $translation;
                    }
                }
            }
            return $result;
        }
        return $this->$attribute;
    }
}