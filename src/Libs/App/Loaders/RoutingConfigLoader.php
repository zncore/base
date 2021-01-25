<?php

namespace ZnCore\Base\Libs\App\Loaders;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RouteCollection;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\Container\ContainerAttributeTrait;

class RoutingConfigLoader /*extends BaseLoader*/ implements LoaderInterface
{

    use ContainerAttributeTrait;

    private $configList;
    
    public function __construct(array $configList = null)
    {
        $this->configList = $configList;
    }

    public function bootstrapApp(string $appName)
    {
        
    }

    public function loadMainConfig(string $appName): array
    {
        $routes = new RouteCollection();
        $fileLocator = new FileLocator();
        $fileLoader = new PhpFileLoader($fileLocator);
        $routingConfigurator = new RoutingConfigurator($routes, $fileLoader, __FILE__, __FILE__);

        foreach ($this->configList as $configFile) {
            $closure = include $configFile;
            $closure($routingConfigurator);
        }

        $config['routeCollection'] = $routes;
        return $config;
    }
}
