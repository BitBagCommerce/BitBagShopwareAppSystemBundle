<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUninstalledEvent;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class AppLifecycleEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ShopRepositoryInterface $shopRepository
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AppUninstalledEvent::class => 'onAppDeleted',
        ];
    }

    public function onAppDeleted(AppUninstalledEvent $event): void
    {
        $shopId = $event->getWebhook()->getSource()->getShopId();
        $shop = $this->shopRepository->getOneByShopId($shopId);

        $this->entityManager->remove($shop);
        $this->entityManager->flush();
    }
}
