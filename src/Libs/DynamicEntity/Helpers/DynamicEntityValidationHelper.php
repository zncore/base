<?php

namespace ZnCore\Base\Libs\DynamicEntity\Helpers;

use Illuminate\Support\Collection;
use Symfony\Component\PropertyAccess\Exception\UninitializedPropertyException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\ConstraintViolationList;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\DynamicEntity\Interfaces\ValidateDynamicEntityInterface;
use ZnCore\Domain\Entities\ValidateErrorEntity;

class DynamicEntityValidationHelper
{

    /**
     * @return array | Collection | ValidateErrorEntity[]
     */
    public static function validate(ValidateDynamicEntityInterface $data): Collection
    {
        $rules = $data->validationRules();
        return self::validateByRulesArray($data, $rules);
    }

    private static function validateByRulesArray(object $entity, array $rules)
    {
        $violations = [];
        $validator = SymfonyValidationHelper::createValidator();
        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        foreach ($rules as $name => $rule) {
            try {
                $value = $propertyAccessor->getValue($entity, $name);
            } catch (UninitializedPropertyException $e) {
                $value = null;
            }
            $vol = $validator->validate($value, $rules[$name]);
            if ($vol->count()) {
                $violations[$name] = $vol;
            }
        }
        return self::prepareUnprocessible($violations);
    }

    /**
     * @param array | ConstraintViolationList[] $violations
     * @return  array | Collection | ValidateErrorEntity[]
     */
    private static function prepareUnprocessible(array $violations): Collection
    {
        $collection = new Collection;
        foreach ($violations as $name => $violationList) {
            foreach ($violationList as $violation) {
                //$name = $violation->propertyPath();
                $violation->getCode();
                $entity = new ValidateErrorEntity;
                $entity->setField($name);
                $message = $violation->getMessage();
                $entity->setMessage($message);
                $entity->setViolation($violation);
                $collection->add($entity);
            }
        }
        return $collection;
    }
}
