<?php

namespace ZnCore\Base\Libs\App\Subscribers;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Helpers\DeprecateHelper;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Base\Libs\Container\Interfaces\ContainerConfiguratorInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerConfiguratorInterface;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;

DeprecateHelper::hardThrow();

class ConfigureEntityManagerSubscriber implements EventSubscriberInterface
{

    use EntityManagerTrait;

    public static function getSubscribedEvents()
    {
        return [
            KernelEventEnum::AFTER_LOAD_CONFIG => 'onAfterLoadConfig',
        ];
    }

    public function onAfterLoadConfig(LoadConfigEvent $event)
    {
        return;

        $container = $event->getKernel()->getContainer();
        $config = $event->getConfig();
        /** @var ContainerConfiguratorInterface $containerConfigurator */
        $containerConfigurator = $container->get(ContainerConfiguratorInterface::class);
//        $containerConfig = $config['container'];
        $containerConfig = $containerConfigurator->getConfig();

        if (!empty($containerConfig)) {
            $this->bindEntityManager($container, $containerConfig);
            /*if (isset($config['entities'])) {
                unset($config['entities']);
            }*/
        }
//        $event->setConfig($config);
    }

    private function bindEntityManager(ContainerInterface $container, $entitiesConfig): void
    {
        /** @var EntityManagerConfiguratorInterface $entityManagerConfigurator */
        $entityManagerConfigurator = $container->get(EntityManagerConfiguratorInterface::class);


        /** @var EntityManagerInterface $em */
        $em = $container->get(EntityManagerInterface::class);
        if (!empty($entitiesConfig['entities'])) {
            foreach ($entitiesConfig['entities'] as $entityClass => $repositoryInterface) {
                $em->bindEntity($entityClass, $repositoryInterface);
            }
        }
        $em->setConfig($entitiesConfig);
    }
}
