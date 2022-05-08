<?php

namespace ZnCore\Base\Libs\App;

use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\Container\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\ConfigManagerInterface;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\App\Libs\ConfigManager;
use ZnCore\Base\Libs\App\Subscribers\ConfigureContainerSubscriber;
use ZnCore\Base\Libs\App\Subscribers\ConfigureEntityManagerSubscriber;
use ZnCore\Base\Libs\Cache\CacheAwareTrait;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnCore\Base\Libs\FileSystem\Helpers\FilePathHelper;
use ZnCore\Contract\Kernel\Interfaces\KernelInterface;

class Kernel implements KernelInterface
{

    use CacheAwareTrait;
    use EventDispatcherTrait;

    protected $container;
    /** @var LoaderInterface[] */
    protected $loaders;
    protected $appName;
    protected $config;

    public function __construct(string $appName)
    {
        define('MICRO_TIME', microtime(true));
        $this->appName = $appName;
        //$this->initCache();
    }

    public function subscribes(): array
    {
        return [
            ConfigureContainerSubscriber::class,
            ConfigureEntityManagerSubscriber::class,
        ];
    }

    protected function initCache()
    {
        $cacheDirectory = FilePathHelper::rootPath() . '/' . $_ENV['CACHE_DIRECTORY'];
        $this->cache = new FilesystemAdapter('kernel', TimeEnum::SECOND_PER_DAY, $cacheDirectory);
    }

    public function setContainer(ContainerInterface $container): void
    {
        $containerConfigurator = ContainerHelper::getContainerConfiguratorByContainer($container);
        $containerConfigurator->singleton(KernelInterface::class, $this);
        $containerConfigurator->singleton(ConfigManagerInterface::class, ConfigManager::class);
        $this->container = $container;
    }

    public function getContainer(): ContainerInterface
    {
        if (!isset($this->container)) {
            $this->setContainer(ContainerHelper::getContainer());
        }
        return $this->container;
    }

    public function setLoader(LoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }

    public function getConfig()
    {
        return $this->config;
    }

    public function init(): void
    {
        $this->config = $this->loadAppConfig();
    }

    public function loadAppConfig(): array
    {
        $config = $this->loadMainConfig($this->appName);
        $event = new LoadConfigEvent($this, $config);
        $this->getEventDispatcher()->dispatch($event, KernelEventEnum::AFTER_LOAD_CONFIG);
        return $event->getConfig();
    }

    protected function loadMainConfig(string $appName): array
    {
        $config = [];
        if($this->loaders) {
            foreach ($this->loaders as $loader) {
                $loader->setContainer($this->getContainer());
                $loader->bootstrapApp($appName);
                $configItem = $loader->loadMainConfig($appName);
                $config = ArrayHelper::merge($config, $configItem);
            }
        }
        return $config;
    }
}
