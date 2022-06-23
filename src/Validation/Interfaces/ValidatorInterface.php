<?php

namespace ZnCore\Base\Validation\Interfaces;

interface ValidatorInterface
{

    public function validateEntity(object $entity): void;

    public function isMatch(object $entity): bool;

}
