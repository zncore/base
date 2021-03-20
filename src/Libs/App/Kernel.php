<?php

namespace ZnCore\Base\Libs\App;

use Packages\Kernel\AdvancedLoader;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\Cache\CacheAwareTrait;
use ZnCore\Domain\Helpers\EntityManagerHelper;

class Kernel
{

    use CacheAwareTrait;

    protected $container;
    protected $loaders;
    protected $appName;

    public function __construct(string $appName)
    {
        define('MICRO_TIME', microtime(true));
        $this->appName = $appName;
        //$this->initCache();
    }

    protected function initCache()
    {
        $cacheDirectory = FileHelper::rootPath() . '/' . $_ENV['CACHE_DIRECTORY'];
        $this->cache = new FilesystemAdapter('kernel', TimeEnum::SECOND_PER_DAY, $cacheDirectory);
    }

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container ?? ContainerHelper::getContainer();
    }

    public function setLoader(LoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }

    public function loadAppConfig(): array
    {
        $config = $this->loadMainConfig($this->appName);
        $this->configure($config['container']);
        unset($config['container']['entities']);
        return $config;
    }

    protected function configure(array $containerConfig)
    {
        ContainerHelper::configureContainer($this->getContainer(), $containerConfig);
        if (!empty($containerConfig['entities'])) {
            EntityManagerHelper::bindEntityManager($this->getContainer(), $containerConfig['entities']);
        }
    }

    protected function loadMainConfig(string $appName): array
    {
        $config = [];
        foreach ($this->loaders as $loader) {
            $loader->setContainer($this->getContainer());
            $loader->bootstrapApp($appName);
            $configItem = $loader->loadMainConfig($appName);
            $config = ArrayHelper::merge($config, $configItem);
        }
        return $config;
    }
}
