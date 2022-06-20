<?php

namespace ZnCore\Base\Libs\Validation\Exceptions;

use Error;
use Illuminate\Support\Collection;
use ZnCore\Base\Libs\Validation\Entities\ValidationErrorEntity;

class UnprocessibleEntityException extends Error
{

    public function __construct(Collection $errorCollection = null)
    {
        if ($errorCollection) {
            $this->setErrorCollection($errorCollection);
        }
    }

    /**
     * @var array | Collection | ValidationErrorEntity[]
     */
    private $errorCollection;

    public function setErrorCollection(Collection $errorCollection)
    {
        $this->errorCollection = $errorCollection;
        $this->updateMessage();
    }

    /**
     * @return array | Collection | ValidationErrorEntity[] | null
     */
    public function getErrorCollection(): ?Collection
    {
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
