<?php

namespace ZnCore\Base\Libs\Validation\Libs\Validators;

use ZnCore\Base\Libs\DynamicEntity\Helpers\DynamicEntityValidationHelper;
use ZnCore\Base\Libs\DynamicEntity\Interfaces\ValidateDynamicEntityInterface;
use ZnCore\Base\Libs\Validation\Interfaces\ValidatorInterface;

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
