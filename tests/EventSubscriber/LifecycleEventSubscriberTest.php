<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUninstalledEvent;
use BitBag\ShopwareAppSystemBundle\EventSubscriber\AppLifecycleEventSubscriber;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Source;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;
use Vin\ShopwareSdk\Data\Context;

final class LifecycleEventSubscriberTest extends TestCase
{
    private const SHOP_ID = 'dgrH7nLU6tlE';

    private EntityManagerInterface $entityManager;

    private ShopRepositoryInterface $shopRepository;

    private AppLifecycleEventSubscriber $eventSubscriber;

    protected function setUp(): void
    {
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        $this->shopRepository = $this->createMock(ShopRepositoryInterface::class);
        $this->eventSubscriber = new AppLifecycleEventSubscriber(
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

        $context = $this->createMock(Context::class);

        $appDeletedEvent = new AppUninstalledEvent($webhook, $context);

        $this->shopRepository
            ->expects(self::once())
            ->method('getOneByShopId')
            ->with(self::SHOP_ID);

        $this->eventSubscriber->onAppDeleted($appDeletedEvent);
    }
}
