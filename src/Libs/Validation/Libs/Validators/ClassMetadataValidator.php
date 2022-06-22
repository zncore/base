<?php

namespace ZnCore\Base\Libs\Validation\Libs\Validators;

use ZnCore\Base\Libs\Validation\Helpers\SymfonyValidationHelper;
use ZnCore\Base\Libs\Validation\Interfaces\ValidationByMetadataInterface;
use ZnCore\Base\Libs\Validation\Interfaces\ValidatorInterface;

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
