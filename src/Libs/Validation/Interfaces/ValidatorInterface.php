<?php

namespace ZnCore\Base\Libs\Validation\Interfaces;

interface ValidatorInterface
{

    public function validateEntity(object $entity): void;

    public function isMatch(object $entity): bool;

}
