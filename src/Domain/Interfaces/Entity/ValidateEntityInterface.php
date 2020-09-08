<?php

namespace ZnCore\Base\Domain\Interfaces\Entity;

interface ValidateEntityInterface
{

    /**
     * @return array
     */
    public function validationRules();

}