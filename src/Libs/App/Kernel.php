<?php

namespace ZnCore\Base\Libs\App;

use Illuminate\Container\Container;
use Packages\Kernel\AdvancedLoader;
use Psr\Container\ContainerInterface;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use ZnCore\Base\Enums\Measure\TimeEnum;
use ZnCore\Base\Legacy\Yii\Helpers\ArrayHelper;
use ZnCore\Base\Legacy\Yii\Helpers\FileHelper;
use ZnCore\Base\Libs\App\Helpers\ContainerHelper;
use ZnCore\Base\Libs\App\Interfaces\LoaderInterface;
use ZnCore\Base\Libs\DotEnv\DotEnv;
use ZnCore\Domain\Helpers\EntityManagerHelper;
use ZnYii\App\Constant;
use ZnYii\App\Loader\BaseLoader;

class Kernel
{
    private $cache;
    //protected $loader;
    protected $container;
    protected $loaders;
    protected $env;

    public function __construct(array $env = null, LoaderInterface $loader = null)
    {
        define('MICRO_TIME', microtime(true));
        //$this->loader = $loader;
        $this->env = $env;
        //$this->initCache($env);
    }

    public function setContainer(ContainerInterface $container): void
    {
        $this->container = $container;
    }

    public function setLoader(LoaderInterface $loader): void
    {
        //$this->loader = $loader;
        $this->loaders[] = $loader;
    }

    /*public function run(array $env = null)
    {
        if($env === null) {
            $env = $this->env;
        }
        $this->init($env);
        $appName = $env['APP_NAME'];
        //Constant::defineBase(realpath(__DIR__ . '/../../../..'));
        //Constant::defineApp($appName);
        $config = $this->loadMainConfig($appName);
        return $config;
    }

    private function init(array $env)
    {
        define('MICRO_TIME', microtime(true));
        //Constant::defineEnv($env);
        //$this->loader->loadYii();
    }*/

    public function loadAppConfig(string $appName): array
    {
        DotEnv::init(__DIR__ . '/../../../../../..');
//        $config = parent::run($_ENV);
        $config = $this->loadMainConfig($appName);
        //dd($config);

        $this->configure($config['container']);
        unset($config['container']['entities']);
        return $config;
    }

    private function configure(array $containerConfig)
    {
        //$container = Container::getInstance();
        ContainerHelper::configureContainer($this->container, $containerConfig);
        if(!empty($containerConfig['entities'])) {
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

    /*private function initCache(array $env)
    {
        $cacheDirectory = FileHelper::path($env['CACHE_DIRECTORY']);
        $this->cache = new FilesystemAdapter('kernel', TimeEnum::SECOND_PER_MINUTE * 20, $cacheDirectory);
    }*/
}
