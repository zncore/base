<?php

namespace ZnCore\Base\Libs\Validation\Helpers;

use Illuminate\Support\Collection;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\Validation\Entities\ValidationErrorEntity;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;

class UnprocessableHelper
{

    public static function throwItem(string $field, string $mesage): void
    {
        $errorCollection = new Collection();
        $ValidationErrorEntity = new ValidationErrorEntity($field, $mesage);
        $errorCollection->add($ValidationErrorEntity);
        throw new UnprocessibleEntityException($errorCollection);
    }

    public static function throwItems(array $errorArray): void
    {
        $errorCollection = self::generateErrorCollectionFromArray($errorArray);
        throw new UnprocessibleEntityException($errorCollection);
    }

    public static function generateErrorCollectionFromArray(array $errorArray): Collection
    {
        $errorCollection = new Collection;
        foreach ($errorArray as $field => $message) {
            if (is_array($message)) {
                if (ArrayHelper::isAssociative($message)) {
                    $ValidationErrorEntity = new ValidationErrorEntity($message['field'], $message['message']);
                } else {
                    foreach ($message as $m) {
                        $ValidationErrorEntity = new ValidationErrorEntity($field, $m);
                        $errorCollection->add($ValidationErrorEntity);
                    }
                }
            } else {
                $ValidationErrorEntity = new ValidationErrorEntity($field, $message);
                $errorCollection->add($ValidationErrorEntity);
            }
        }
        return $errorCollection;
    }
}
