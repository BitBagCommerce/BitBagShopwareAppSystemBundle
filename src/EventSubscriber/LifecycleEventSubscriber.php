<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeletedEvent;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class LifecycleEventSubscriber implements EventSubscriberInterface
{
    private EntityManagerInterface $entityManager;

    private ShopRepositoryInterface $shopRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ShopRepositoryInterface $shopRepository
    ) {
        $this->entityManager = $entityManager;
        $this->shopRepository = $shopRepository;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            AppDeletedEvent::class => 'onAppDeleted',
        ];
    }

    public function onAppDeleted(AppDeletedEvent $event): void
    {
        $shopId = $event->getWebhook()->getSource()->getShopId();
        $shop = $this->shopRepository->getOneByShopId($shopId);

        $this->entityManager->remove($shop);
        $this->entityManager->flush();
    }
}
