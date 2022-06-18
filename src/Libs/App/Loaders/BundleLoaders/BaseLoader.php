<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\AbstractAdapter;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Base\BaseBundle;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\Cache\CacheAwareTrait;
use ZnCore\Base\Libs\Container\Traits\ContainerAttributeTrait;

abstract class BaseLoader
{

    use ContainerAttributeTrait;
    use CacheAwareTrait;

    private $configManager;
    protected $useCache = false;
    protected $name;

    abstract public function loadAll(array $bundles): array;

    public function __construct(ConfigManagerInterface $configManager)
    {
        $this->setConfigManager($configManager);
    }

    public function isUseCache(): bool
    {
        return $this->useCache;
    }

    public function setUseCache(bool $useCache): void
    {
        $this->useCache = $useCache;
    }
    
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /*protected function loadFromCache($callback) {
        if($this->useCache && $this->getCache() instanceof AbstractAdapter) {
            $key = 'kernel_bundle_loader2_' . $this->getName();
            $config = $this->cache->get($key, $callback);
        } else {
            $config = call_user_func($callback);
        }
        return $config;
    }

    protected function hasConfigManager(): bool
    {
        return isset($this->configManager);
    }*/

    protected function getConfigManager(): ConfigManagerInterface
    {
        return $this->configManager;
    }

    protected function setConfigManager(ConfigManagerInterface $configManager): void
    {
        $this->configManager = $configManager;
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
