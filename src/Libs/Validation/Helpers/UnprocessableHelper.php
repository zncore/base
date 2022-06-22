<?php

namespace ZnCore\Base\Libs\Validation\Helpers;

use Illuminate\Support\Collection;
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
        $errorCollection = ErrorCollectionHelper::flatArrayToCollection($errorArray);
        throw new UnprocessibleEntityException($errorCollection);
    }
}
