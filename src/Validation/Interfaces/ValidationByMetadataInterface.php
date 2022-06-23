<?php

namespace ZnCore\Base\Validation\Interfaces;

use Symfony\Component\Validator\Mapping\ClassMetadata;

interface ValidationByMetadataInterface
{

    public static function loadValidatorMetadata(ClassMetadata $metadata);
}