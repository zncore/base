<?php

namespace ZnCore\Base\Libs\App\Base;

use Psr\Container\ContainerInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Contracts\EventDispatcher\Event;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Helpers\EnvHelper;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Base\Libs\Container\Traits\ContainerAttributeTrait;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Base\Libs\Event\Interfaces\EventDispatcherConfiguratorInterface;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;
use ZnCore\Base\Libs\App\Enums\AppEventEnum;
use ZnCore\Base\Libs\App\Interfaces\AppInterface;
use ZnCore\Base\Libs\App\Libs\ZnCore;
use ZnTool\Dev\VarDumper\Facades\SymfonyDumperFacade;

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

    protected function loadBundlesFromEnvPath(): void {
        $bundles = [];
        if (DotEnv::get('BUNDLES_CONFIG_FILE')) {
            $bundles = include __DIR__ . '/../../../../../server.soc/' . DotEnv::get('BUNDLES_CONFIG_FILE');
        }
        $this->addBundles($bundles);
    }

    public function addImport(array $import): void
    {
        $this->import = ArrayHelper::merge($this->import, $import);
    }

    public function import(): array {
        return $this->import;
    }

    protected function bundles(): array {
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
        DotEnv::init(DotEnv::ROOT_PATH, $_ENV['APP_MODE']);
//        EnvHelper::prepareTestEnv();
//        DotEnv::init();
        EnvHelper::setErrorVisibleFromEnv();
    }

    protected function initContainer(): void
    {
        $this->configContainer($this->containerConfigurator);
    }

    protected function initBundles(): void
    {
        $this->znCore->loadBundles($this->bundles(), $this->import(), $this->appName());
    }

    protected function initDispatcher(): void
    {
        $eventDispatcherConfigurator = $this->getContainer()->get(EventDispatcherConfiguratorInterface::class);
        $this->configDispatcher($eventDispatcherConfigurator);
    }

    protected function configDispatcher(EventDispatcherConfiguratorInterface $configurator): void {

    }

    protected function dispatchEvent(string $eventName): void {
        $event = new Event();
        $this->getEventDispatcher()->dispatch($event, $eventName);
    }
}