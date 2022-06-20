<?php

namespace ZnCore\Base\Libs\Entity\Interfaces;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface ValidateEntityByMetadataInterface
{

    public static function loadValidatorMetadata(ClassMetadata $metadata);
}