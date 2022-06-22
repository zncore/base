<?php

namespace ZnCore\Base\Libs\Validation\Helpers;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\ConstraintViolationList;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\DynamicEntity\Helpers\DynamicEntityValidationHelper;
use ZnCore\Base\Libs\DynamicEntity\Interfaces\ValidateDynamicEntityInterface;
use ZnCore\Base\Libs\Validation\Entities\ValidationErrorEntity;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Base\Libs\Validation\Libs\ValidatorManager;

class ValidationHelper
{

    public static function validateEntity(object $entity): void
    {
        $container = ContainerHelper::getContainer();
        $validator = $container->get(ValidatorManager::class);
        $validator->validateEntity($entity);

//        $errorCollection = self::validate($entity);
//        if ($errorCollection && $errorCollection->count() > 0) {
//            $exception = new UnprocessibleEntityException;
//            $exception->setErrorCollection($errorCollection);
//            throw $exception;
//        }
    }

//    /**
//     * @return array | Collection | ValidationErrorEntity[]
//     */
//    private static function validate(object $data): ?Collection
//    {
//        if ($data instanceof ValidateDynamicEntityInterface) {
//            return DynamicEntityValidationHelper::validate($data);
//        } elseif ($data instanceof ValidationByMetadataInterface) {
//            return SymfonyValidationHelper::validate($data);
//        } else {
//            return null;
//        }
//    }

    /**
     * @return array | Collection | ValidationErrorEntity[]
     */
    public static function validateValue($value, array $rules): ConstraintViolationList
    {
        $validator = SymfonyValidationHelper::createValidator();
        $violations = $validator->validate($value, $rules);
        return $violations;
    }
}
