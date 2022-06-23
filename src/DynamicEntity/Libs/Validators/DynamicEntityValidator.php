<?php

namespace ZnCore\Base\DynamicEntity\Libs\Validators;

use ZnCore\Base\DynamicEntity\Helpers\DynamicEntityValidationHelper;
use ZnCore\Base\DynamicEntity\Interfaces\ValidateDynamicEntityInterface;
use ZnCore\Base\Validation\Interfaces\ValidatorInterface;
use ZnCore\Base\Validation\Libs\Validators\BaseValidator;

class DynamicEntityValidator extends BaseValidator implements ValidatorInterface
{

    public function validateEntity(object $entity): void
    {
        $errorCollection = DynamicEntityValidationHelper::validate($data);
        $this->handleResult($errorCollection);
    }

    public function isMatch(object $entity): bool
    {
        return $entity instanceof ValidateDynamicEntityInterface;
    }
}
