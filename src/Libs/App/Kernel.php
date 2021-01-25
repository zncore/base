<?php

namespace ZnCore\Base\Libs\App;

use Illuminate\Container\Container;
use Packages\Kernel\AdvancedLoader;
use Psr\Container\ContainerInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Domain\Helpers\EntityManagerHelper;

class Kernel
{

    protected $container;
    protected $loaders;
    protected $appName;

    public function __construct(string $appName)
    {
        define('MICRO_TIME', microtime(true));
        $this->appName = $appName;
    }

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        return $this->container ??  ContainerHelper::getContainer();
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
        ContainerHelper::configureContainer($this->container, $containerConfig);
        if (!empty($containerConfig['entities'])) {
            EntityManagerHelper::bindEntityManager($this->container, $containerConfig['entities']);
        }
    }

    protected function loadMainConfig(string $appName): array
    {
        $config = [];
        foreach ($this->loaders as $loader) {
            $loader->bootstrapApp($appName);
            $configItem = $loader->loadMainConfig($appName);
            $config = ArrayHelper::merge($config, $configItem);
        }
        return $config;
    }
}
