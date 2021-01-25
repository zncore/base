<?php

namespace ZnCore\Base\Libs\App\Loaders\BundleLoaders;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\Component\Routing\Loader\PhpFileLoader;
use Symfony\Component\Routing\RouteCollection;

class SymfonyRoutesLoader extends BaseLoader
{

    public function loadAll(array $bundles): array
    {
        $routes = new RouteCollection();
        $fileLocator = new FileLocator();
        $fileLoader = new PhpFileLoader($fileLocator);
        $routingConfigurator = new RoutingConfigurator($routes, $fileLoader, __FILE__, __FILE__);

        foreach ($bundles as $bundle) {
            $loadedConfig = $this->load($bundle);
            if ($loadedConfig) {
                foreach ($loadedConfig as $configFile) {
                    $closure = include $configFile;
                    $closure($routingConfigurator);
                }
            }
        }
        $config['routeCollection'] = $routes;
        return $config;
    }
}
