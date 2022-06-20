<?php

namespace ZnCore\Base\Libs\Validation\Helpers;

use Illuminate\Support\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use ZnBundle\Eav\Domain\Entities\DynamicEntity;
use ZnBundle\Eav\Domain\Entities\EntityEntity;
use ZnBundle\Eav\Domain\Libs\TypeNormalizer;
use ZnBundle\Eav\Domain\Libs\Validator;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\DynamicEntity\Helpers\DynamicEntityValidationHelper;
use ZnCore\Base\Libs\Validation\Entities\ValidationErrorEntity;
use ZnCore\Base\Libs\Validation\Exceptions\UnprocessibleEntityException;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Base\Libs\DynamicEntity\Interfaces\ValidateDynamicEntityInterface;

class ValidationHelper
{

    public static function collectionToArray(Collection $errorCollection): array
    {
        $array = [];
        /** @var ValidationErrorEntity $ValidationErrorEntity */
        foreach ($errorCollection as $ValidationErrorEntity) {
            $array[] = [
                'field' => $ValidationErrorEntity->getField(),
                'message' => $ValidationErrorEntity->getMessage(),
            ];
        }
        return $array;
    }

    /*public static function generateErrorCollectionFromArray(array $errorArray): Collection
    {
        $errorCollection = new Collection;
        foreach ($errorArray as $field => $message) {
            if (is_array($message)) {
                if (ArrayHelper::isAssociative($message)) {
                    $ValidationErrorEntity = new ValidationErrorEntity;
                    $ValidationErrorEntity->setField($message['field']);
                    $ValidationErrorEntity->setMessage($message['message']);
                } else {
                    foreach ($message as $m) {
                        $ValidationErrorEntity = new ValidationErrorEntity;
                        $ValidationErrorEntity->setField($field);
                        $ValidationErrorEntity->setMessage($m);
                    }
                }
            } else {
                $ValidationErrorEntity = new ValidationErrorEntity;
                $ValidationErrorEntity->setField($field);
                $ValidationErrorEntity->setMessage($message);
            }
        }
        $errorCollection->add($ValidationErrorEntity);
        return $errorCollection;
    }*/

    public static function validateEntity(object $entity): void
    {
        $errorCollection = self::validate($entity);
        if ($errorCollection && $errorCollection->count() > 0) {
            $exception = new UnprocessibleEntityException;
            $exception->setErrorCollection($errorCollection);
            throw $exception;
        }
    }

    /**
     * @return array | Collection | ValidationErrorEntity[]
     */
    private static function validate(object $data): ?Collection
    {
        if ($data instanceof ValidateDynamicEntityInterface) {
//            dump($data);
            return DynamicEntityValidationHelper::validate($data);
        } elseif($data instanceof ValidationByMetadataInterface) {
            return SymfonyValidationHelper::validate($data);
        } else {
            return null;
        }
    }

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
