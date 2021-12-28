<?php

namespace ZnCore\Base\Libs\I18Next\Traits;

use Illuminate\Support\Collection;
use ZnBundle\Language\Domain\Entities\LanguageEntity;
use ZnBundle\Language\Domain\Interfaces\Services\LanguageServiceInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\I18Next\Enums\LanguageI18nEnum;
use ZnBundle\Language\Domain\Interfaces\Services\RuntimeLanguageServiceInterface;
use ZnCore\Domain\Helpers\EntityHelper;

trait I18nTrait
{

    protected $_language = "ru";

    /** @var Collection | LanguageEntity[] */
    static protected $_languages = null;

    protected function _forgeLlanguages(LanguageServiceInterface $languageService = null) {
        if(self::$_languages) {
            return;
        }
        if(!$languageService) {
            $languageService = ContainerHelper::getContainer()->get(LanguageServiceInterface::class);
        }
        self::$_languages = $languageService->allEnabled();
    }

    protected function _setRuntimeLanguageService(RuntimeLanguageServiceInterface $languageService) {
        $this->_setCurrentLanguage($languageService->getLanguage());
    }

    protected function _setCurrentLanguage(string $language) {
        $this->_language = LanguageI18nEnum::encode($language);
    }

    protected function _getCurrentLanguage(string $defaultLanguage = null): string {
        $language = $defaultLanguage ?: $this->_language;
        $encodedLanguage = LanguageI18nEnum::encode($language);
        $language = $encodedLanguage ?: $language;
        return $language;
    }

    protected function _setI18n(string $attribute, $value, string $language = null): void {
        $this->$attribute = $value;
        $i18nAttribute = $attribute . 'I18n';
        $language = $this->_getCurrentLanguage($language);
        $this->{$i18nAttribute}[$language] = $value;
    }

    protected function _getI18n(string $attribute, string $language = null): ?string
    {
        $i18nAttribute = $attribute . 'I18n';
        $value = EntityHelper::getValue($this, $i18nAttribute);
        if (!empty($value)) {
            $translations = !is_array($value) ? json_decode($value, JSON_OBJECT_AS_ARRAY) : $value;
            $language = $this->_getCurrentLanguage($language);
            $result = ArrayHelper::getValue($translations, $language);
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

    protected function _getI18nArray(string $attribute, string $language = null) {
        $language = $this->_getCurrentLanguage($language);
        $i18nAttribute = $attribute . 'I18n';
        $result = [];
        if(!empty($this->$i18nAttribute)) {
            $result = $this->$i18nAttribute;
        } elseif(!empty($this->$attribute)) {
            $result = [
                $language => $this->$attribute
            ];
        }
        $this->_forgeLlanguages();
        foreach (self::$_languages as $languageEntity) {
            $code = $languageEntity->getCode();
            if(empty($result[$code])) {
                $result[$code] = ArrayHelper::first($result);
            }
        }
        return $result;
    }
}