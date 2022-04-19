<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\EventSubscriber\LifecycleEventSubscriber;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeletedEvent;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Source;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

final class LifecycleEventSubscriberTest extends TestCase
{
    private const SHOP_ID = 'dgrH7nLU6tlE';

    private EntityManagerInterface $entityManager;

    private ShopRepositoryInterface $shopRepository;

    private LifecycleEventSubscriber $eventSubscriber;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->shopRepository = $this->createMock(ShopRepositoryInterface::class);
        $this->eventSubscriber = new LifecycleEventSubscriber(
            $this->entityManager,
            $this->shopRepository
        );
    }

    public function testOnAppDeleted(): void
    {
        $webhook = new Webhook();
        $source = new Source();
        $source->setShopId(self::SHOP_ID);
        $webhook->setSource($source);

        $appDeletedEvent = new AppDeletedEvent($webhook);

        $this->shopRepository
            ->expects(self::once())
            ->method('getOneByShopId')
            ->with(self::SHOP_ID);

        $this->eventSubscriber->onAppDeleted($appDeletedEvent);
    }
}
