<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use BitBag\ShopwareAppSystemBundle\Exception\UnresolvedContextException;
use BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent\LifecycleEventFactory;
use BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent\LifecycleEventFactoryInterface;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppActivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeactivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeletedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppInstalledEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppUpdatedEvent;
use PHPUnit\Framework\TestCase;
use Vin\ShopwareSdk\Data\Context;

final class LifecycleEventFactoryTest extends TestCase
{
    private LifecycleEventFactoryInterface $lifecycleEventFactory;

    private EventInterface $shopwareEvent;

    protected function setUp(): void
    {
        $this->lifecycleEventFactory = new LifecycleEventFactory();
        $this->shopwareEvent = $this->createMock(EventInterface::class);
    }

    /** @dataProvider eventDataWithoutContextProvider */
    public function testWithoutContext(string $eventName, string $eventClass): void
    {
        $event = $this->lifecycleEventFactory->createNew(
            $eventName,
            $this->shopwareEvent,
            null
        )
        ;

        self::assertEquals($eventClass, \get_class($event));
    }

    /** @dataProvider eventDataWithContextProvider */
    public function testWithContext(string $eventName, string $eventClass): void
    {
        $event = $this->lifecycleEventFactory->createNew(
            $eventName,
            $this->shopwareEvent,
            $this->createMock(Context::class)
        )
        ;

        self::assertEquals($eventClass, \get_class($event));
    }

    public function testWithMissingContext(): void
    {
        $this->expectException(UnresolvedContextException::class);

        $this->lifecycleEventFactory->createNew(
            'activated',
            $this->shopwareEvent,
            null
        );
    }

    public function eventDataWithoutContextProvider(): array
    {
        return [
            ['deactivated', AppDeactivatedEvent::class],
            ['deleted', AppDeletedEvent::class],
        ];
    }

    public function eventDataWithContextProvider(): array
    {
        return [
            ['activated', AppActivatedEvent::class],
            ['installed', AppInstalledEvent::class],
            ['updated', AppUpdatedEvent::class],
        ];
    }
}
