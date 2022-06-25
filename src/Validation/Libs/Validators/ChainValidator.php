<?php

namespace ZnCore\Base\Validation\Libs\Validators;

use Illuminate\Support\Collection;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Instance\Libs\Resolvers\InstanceResolver;
use ZnCore\Base\Container\Traits\ContainerAwareAttributeTrait;
use ZnCore\Base\Validation\Interfaces\ValidatorInterface;
use ZnLib\Components\DynamicEntity\Libs\Validators\DynamicEntityValidator;

class ChainValidator implements ValidatorInterface
{

    use ContainerAwareAttributeTrait;

    /** @var Collection | ValidatorInterface[] */
    private $validators;

    public function __construct(ContainerInterface $container)
    {
        $this->setContainer($container);
        $validators = [
            ClassMetadataValidator::class,
            DynamicEntityValidator::class,
        ];
        $instanceResolver = new InstanceResolver($container);
        $instances = new Collection();
        foreach ($validators as $validatorDefinition) {
            $validatorInstance = $instanceResolver->ensure($validatorDefinition);
            $instances->add($validatorInstance);
        }
        $this->validators = $instances;
    }

    public function validateEntity(object $entity): void
    {
        foreach ($this->validators as $validatorInstance) {
            if ($validatorInstance->isMatch($entity)) {
                $validatorInstance->validateEntity($entity);
            }
        }
    }

    public function isMatch(object $entity): bool
    {
        return true;
    }
}
