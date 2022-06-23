<?php

namespace ZnCore\Base\App\Base;

use Psr\Container\ContainerInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\App\Enums\AppEventEnum;
use ZnCore\Base\Env\Helpers\EnvHelper;
use ZnCore\Base\App\Interfaces\AppInterface;
use ZnCore\Base\App\Interfaces\LoaderInterface;
use ZnCore\Base\App\Libs\ZnCore;
use ZnCore\Base\App\Loaders\BundleLoader;
use ZnCore\Base\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Container\Libs\BundleLoaders\ContainerLoader;
use ZnCore\Base\Container\Traits\ContainerAttributeTrait;
use ZnCore\Base\DotEnv\Domain\Libs\DotEnv;
use ZnCore\Base\EventDispatcher\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\EventDispatcher\Traits\EventDispatcherTrait;
use ZnCore\Base\FileSystem\Helpers\FilePathHelper;
use ZnCore\Base\I18Next\Libs\BundleLoaders\I18NextLoader;
use ZnDatabase\Migration\Domain\Libs\BundleLoaders\MigrationLoader;
use ZnLib\Console\Domain\Libs\BundleLoaders\ConsoleLoader;
use ZnUser\Rbac\Domain\Libs\BundleLoaders\RbacConfigLoader;

abstract class BaseApp implements AppInterface
{

    use ContainerAttributeTrait;
    use EventDispatcherTrait;

    private $containerConfigurator;
    private $znCore;
    protected $bundles = [];
    private $import = [];

    abstract public function appName(): string;

    public function addBundles(array $bundles): void
    {
        $this->bundles = ArrayHelper::merge($this->bundles, $bundles);
    }

    protected function loadBundlesFromEnvPath(): void
    {
        $bundles = [];
        if (DotEnv::get('BUNDLES_CONFIG_FILE')) {
            $bundles = include __DIR__ . '/../../../../../../' . DotEnv::get('BUNDLES_CONFIG_FILE');
        }
        $this->addBundles($bundles);
    }

    /*public function addImport(array $import): void
    {
        $this->import = ArrayHelper::merge($this->import, $import);
    }*/

    public function import(): array
    {
        return $this->import;
    }

    protected function bundles(): array
    {
        return $this->bundles;
    }

    public function __construct(
        ContainerInterface $container,
        EventDispatcherInterface $dispatcher,
        ZnCore $znCore,
        ContainerConfiguratorInterface $containerConfigurator
    )
    {
        $this->setContainer($container);
        $this->setEventDispatcher($dispatcher);
        $this->containerConfigurator = $containerConfigurator;
        $this->znCore = $znCore;
//        defined('REQUEST_ID') OR define('REQUEST_ID', Uuid::v4()->toRfc4122());
    }

    public function init(): void
    {
        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_ENV);
        $this->initEnv();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_ENV);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_CONTAINER);
        $this->initContainer();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_CONTAINER);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_BUNDLES);
        $this->initBundles();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_BUNDLES);

        $this->dispatchEvent(AppEventEnum::BEFORE_INIT_DISPATCHER);
        $this->initDispatcher();
        $this->dispatchEvent(AppEventEnum::AFTER_INIT_DISPATCHER);
    }

    protected function initEnv(): void
    {
        DotEnv::init($_ENV['APP_MODE']);
//        EnvHelper::prepareTestEnv();
//        DotEnv::init();
        EnvHelper::setErrorVisibleFromEnv();
    }

    protected function initContainer(): void
    {
        $this->configContainer($this->containerConfigurator);
    }

    protected function bundleLoaders(): array
    {
        return include __DIR__ . '/../config/bundleLoaders.php';
    }

    protected function createBundleLoaderInstance(): LoaderInterface
    {
        $bundleLoader = new BundleLoader($this->bundles(), $this->import());
        $loaders = $this->bundleLoaders();
        if ($loaders) {
            foreach ($loaders as $loaderName => $loaderDefinition) {
                $bundleLoader->addLoaderConfig($loaderName, $loaderDefinition);
            }
        }
        return $bundleLoader;
    }

    protected function initBundles(): void
    {
        $bundleLoader = $this->createBundleLoaderInstance();
        $this->znCore->loadConfig($bundleLoader, $this->appName());
//        $this->znCore->loadBundles($this->bundles(), $this->import(), $this->appName());
    }

    protected function initDispatcher(): void
    {
        $eventDispatcherConfigurator = $this->getContainer()->get(EventDispatcherConfiguratorInterface::class);
        $this->configDispatcher($eventDispatcherConfigurator);
    }

    protected function configDispatcher(EventDispatcherConfiguratorInterface $configurator): void
    {

    }

    protected function dispatchEvent(string $eventName): void
    {
        $event = new Event();
        $this->getEventDispatcher()->dispatch($event, $eventName);
    }
}
