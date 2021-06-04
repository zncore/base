<?php

namespace ZnCore\Base\Libs\App\Subscribers;

use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use ZnCore\Base\Libs\App\Enums\KernelEventEnum;
use ZnCore\Base\Libs\App\Events\LoadConfigEvent;
use ZnCore\Domain\Interfaces\Libs\EntityManagerInterface;
use ZnCore\Domain\Traits\EntityManagerTrait;

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
        $config = $event->getConfig();
        $container = $event->getKernel()->getContainer();
        if (isset($config['container'])) {
            $this->bindEntityManager($container, $config['container']);
            if (isset($config['container']['entities'])) {
                unset($config['container']['entities']);
            }
        }
        $event->setConfig($config);
    }

    private function bindEntityManager(ContainerInterface $container, $entitiesConfig): void
    {
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
