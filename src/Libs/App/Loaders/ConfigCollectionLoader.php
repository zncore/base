<?php

namespace ZnCore\Base\Libs\App\Loaders;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;
use ZnCore\Base\Libs\Event\Traits\EventDispatcherTrait;

class ConfigCollectionLoader implements LoaderInterface
{

    use ContainerAttributeTrait;
    use EventDispatcherTrait;

    protected $loaders;

    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    public function bootstrapApp(string $appName)
    {

    }

    public function loadMainConfig(string $appName): array
    {
        $config = [];
        if ($this->loaders) {
            foreach ($this->loaders as $loader) {
                $loader->setContainer($this->getContainer());
                $loader->bootstrapApp($appName);
                $configItem = $loader->loadMainConfig($appName);
                $config = ArrayHelper::merge($config, $configItem);
            }
        }

        $event = new LoadConfigEvent($this, $config);
        $this->getEventDispatcher()->dispatch($event, KernelEventEnum::AFTER_LOAD_CONFIG);
        return $event->getConfig();
    }

    public function setLoader(LoaderInterface $loader): void
    {
        $this->loaders[] = $loader;
    }
}
