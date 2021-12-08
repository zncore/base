<?php

namespace ZnCore\Base\Exceptions;

use Exception;

class AlreadyExistsException extends Exception
{

    private $entity;
    private $fields = [];

    public function getEntity(): ?object
    {
        return $this->entity;
    }

    public function setEntity(object $entity): void
    {
        $this->entity = $entity;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function setFields($fields): void
    {
        $this->fields = $fields;
    }
}
