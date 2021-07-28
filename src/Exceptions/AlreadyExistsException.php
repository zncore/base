<?php

namespace ZnCore\Base\Exceptions;

use Exception;

class AlreadyExistsException extends Exception
{

    private $entity;

    public function getEntity(): ?object
    {
        return $this->entity;
    }

    public function setEntity(object $entity): void
    {
        $this->entity = $entity;
    }
}
