<?php

namespace ZnCore\Base\Validation\Helpers;

use Illuminate\Support\Collection;
use ZnCore\Base\Validation\Entities\ValidationErrorEntity;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;

class UnprocessableHelper
{

    public static function throwItem(string $field, string $mesage): void
    {
        $errorCollection = new Collection();
        $validationErrorEntity = new ValidationErrorEntity($field, $mesage);
        $errorCollection->add($validationErrorEntity);
        throw new UnprocessibleEntityException($errorCollection);
    }

    public static function throwItems(array $errorArray): void
    {
        $errorCollection = ErrorCollectionHelper::flatArrayToCollection($errorArray);
        throw new UnprocessibleEntityException($errorCollection);
    }
}
