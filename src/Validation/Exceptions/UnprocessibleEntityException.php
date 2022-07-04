<?php

namespace ZnCore\Base\Validation\Exceptions;

use Error;
use ZnCore\Domain\Collection\Libs\Collection;
use Symfony\Component\Validator\ConstraintViolation;
use ZnCore\Base\Validation\Entities\ValidationErrorEntity;

class UnprocessibleEntityException extends Error
{

    public function __construct(Collection $errorCollection = null)
    {
        if ($errorCollection) {
            $this->setErrorCollection($errorCollection);
        }
    }

    /**
     * @var array | \ZnCore\Domain\Collection\Interfaces\Enumerable | ValidationErrorEntity[]
     */
    private $errorCollection;

    public function setErrorCollection(Collection $errorCollection)
    {
        $this->errorCollection = $errorCollection;
        $this->updateMessage();
    }

    /**
     * @return array | \ZnCore\Domain\Collection\Interfaces\Enumerable | ValidationErrorEntity[] | null
     */
    public function getErrorCollection(): ?Collection
    {
        if($this->errorCollection) {
            foreach ($this->errorCollection as $errorEntity) {
                if(!$errorEntity->getViolation()) {
                    $violation = new ConstraintViolation($errorEntity->getMessage(), null, [], null, $errorEntity->getField(), null);
                    $errorEntity->setViolation($violation);
                }
            }
        }
        return $this->errorCollection;
    }

    public function add(string $field, string $message): UnprocessibleEntityException
    {
        if (!isset($this->errorCollection)) {
            $this->errorCollection = new Collection;
        }
        $this->errorCollection[] = new ValidationErrorEntity($field, $message);
        $this->updateMessage();
        return $this;
    }

    protected function updateMessage()
    {
        $message = '';
        foreach ($this->errorCollection as $errorEntity) {
            $message .= $errorEntity->getField() . ': ' . $errorEntity->getMessage();
        }
        $this->message = $message;
    }
}
