<?php

namespace ZnCore\Base\Libs\I18Next\Mappers;

use ZnCore\Base\Helpers\ClassHelper;
use ZnCore\Contract\Mapper\Interfaces\MapperInterface;
use ZnCore\Domain\Helpers\EntityHelper;

class I18nMapper implements MapperInterface
{

    private $entityClass;
    private $attributes;

    public function __construct(string $entityClass, array $attributes)
    {
        $this->entityClass = $entityClass;
        $this->attributes = $attributes;
    }

    public function encode($entity): array
    {
        $data = EntityHelper::toArrayForTablize($entity);

        foreach ($this->attributes as $attribute) {
            $data[$attribute] = json_encode($data[$attribute], JSON_UNESCAPED_UNICODE);
        }

        return $data;
    }

    public function decode(array $row)
    {
        foreach ($this->attributes as $attribute) {
            $row[$attribute] = json_decode($row[$attribute], JSON_OBJECT_AS_ARRAY);
        }

        $entity = ClassHelper::createInstance($this->entityClass);
        EntityHelper::setAttributes($entity, $row);
        return $entity;
    }
}
