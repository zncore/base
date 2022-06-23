<?php

namespace ZnCore\Base\App\Loaders;

use Psr\Container\ContainerInterface;
use ZnCore\Base\Arr\Helpers\ArrayHelper;
use ZnCore\Base\App\Enums\KernelEventEnum;
use ZnCore\Base\App\Events\LoadConfigEvent;
use ZnCore\Base\App\Interfaces\LoaderInterface;
use ZnCore\Base\Container\Traits\ContainerAttributeTrait;
use ZnCore\Base\EventDispatcher\Traits\EventDispatcherTrait;

class ConfigCollectionLoader implements LoaderInterface
{

    use ContainerAttributeTrait;
    use EventDispatcherTrait;

    protected $loaders;

    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    public function loadMainConfig(string $appName): array
    {
        $config = [];
        if ($this->loaders) {
            foreach ($this->loaders as $loader) {
//                $loader->setContainer($this->getContainer());
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
