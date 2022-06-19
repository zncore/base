<?php

namespace ZnCore\Base\Libs\I18Next\Traits;

use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\I18Next\Enums\LanguageI18nEnum;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;

DeprecateHelper::hardThrow();

/**
 * Trait LanguageTrait
 * @package ZnCore\Base\Libs\I18Next\Traits
 * @deprecated
 * @see I18nTrait
 */
trait LanguageTrait
{

    protected $_language = "ru";

    /*protected function setRuntimeLanguageService(RuntimeLanguageServiceInterface $languageService) {
        $this->_language = $languageService->getLanguage();
    }

    protected function _setCurrentLanguage(string $language) {
        $this->_language = $language;
    }

    protected function _setI18n(string $attribute, $value): void {
        $this->$attribute = $value;
        $i18nAttribute = $attribute . 'I18n';
        $this->{$i18nAttribute}[$this->_language] = $value;
    }*/

    protected function i18n(string $attribute): ?string
    {
        return $this->_getI18n($attribute);
    }

    protected function _getI18n(string $attribute): ?string
    {
        $i18nAttribute = $attribute . 'I18n';
        if (!empty($this->$i18nAttribute)) {
            $translations = !is_array($this->$i18nAttribute) ? json_decode($this->$i18nAttribute, JSON_OBJECT_AS_ARRAY) : $this->$i18nAttribute;
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

    /*protected function _getI18nArray(string $attribute) {
        $i18nAttribute = $attribute . 'I18n';
        if(!empty($this->$i18nAttribute)) {
            return $this->$i18nAttribute;
        } elseif(!empty($this->$attribute)) {
            return [
                $this->_language => $this->$attribute
            ];
        }
    }*/
}