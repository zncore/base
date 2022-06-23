<?php

namespace ZnCore\Base\Validation\Libs\Validators;

use ZnCore\Base\Validation\Helpers\SymfonyValidationHelper;
use ZnCore\Base\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Base\Validation\Interfaces\ValidatorInterface;

class ClassMetadataValidator extends BaseValidator implements ValidatorInterface
{

    public function validateEntity(object $entity): void
    {
        $errorCollection = SymfonyValidationHelper::validate($entity);
        $this->handleResult($errorCollection);
    }

    public function isMatch(object $entity): bool
    {
        return $entity instanceof ValidationByMetadataInterface;
    }
}
