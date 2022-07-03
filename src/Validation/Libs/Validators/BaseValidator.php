<?php

namespace ZnCore\Base\Validation\Libs\Validators;

use ZnCore\Domain\Collection\Interfaces\Enumerable;
use ZnCore\Base\Validation\Exceptions\UnprocessibleEntityException;

class BaseValidator
{

    protected function handleResult(?Enumerable $errorCollection): void
    {
        if ($errorCollection && $errorCollection->count() > 0) {
            $exception = new UnprocessibleEntityException;
            $exception->setErrorCollection($errorCollection);
            throw $exception;
        }
    }
}
