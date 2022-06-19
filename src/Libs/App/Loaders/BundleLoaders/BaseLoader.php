<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\ConfigManager\Traits\ConfigManagerAwareTrait;
use ZnCore\Base\Libs\Container\Traits\ContainerAttributeTrait;

abstract class BaseLoader
{

    use ContainerAttributeTrait;
    use ConfigManagerAwareTrait;

    protected $name;

    abstract public function loadAll(array $bundles): array;

    public function __construct(ContainerInterface $container, ConfigManagerInterface $configManager)
    {
        $this->setContainer($container);
        $this->setConfigManager($configManager);
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    protected function load(BaseBundle $bundle): array
    {
        if (!$this->isAllow($bundle)) {
            return [];
        }
        return call_user_func([$bundle, $this->getName()]);
    }

    protected function isAllow(BaseBundle $bundle): bool
    {
        return method_exists($bundle, $this->getName());
    }
}
