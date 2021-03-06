<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppActivatedEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppDeactivatedEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppInstalledEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUninstalledEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUpdatedEvent;
use BitBag\ShopwareAppSystemBundle\Factory\AppLifecycleEvent\AppLifecycleEventFactory;
use BitBag\ShopwareAppSystemBundle\Factory\AppLifecycleEvent\AppLifecycleEventFactoryInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use PHPUnit\Framework\TestCase;
use Vin\ShopwareSdk\Data\Context;

final class AppLifecycleEventFactoryTest extends TestCase
{
    private AppLifecycleEventFactoryInterface $lifecycleEventFactory;

    private WebhookInterface $webhook;

    protected function setUp(): void
    {
        $this->lifecycleEventFactory = new AppLifecycleEventFactory();
        $this->webhook = $this->createMock(WebhookInterface::class);
    }

    /** @dataProvider eventDataWithContextProvider */
    public function testWithContext(string $eventName, string $eventClass): void
    {
        $event = $this->lifecycleEventFactory->createNew(
            $eventName,
            $this->webhook,
            $this->createMock(Context::class)
        );

        self::assertEquals($eventClass, $event::class);
    }

    /** @dataProvider eventDataWithoutContextProvider */
    public function testWithoutContext(string $eventName, string $eventClass): void
    {
        $event = $this->lifecycleEventFactory->createNew(
            $eventName,
            $this->webhook,
        );

        self::assertEquals($eventClass, $event::class);
    }

    public function eventDataWithContextProvider(): array
    {
        return [
            ['activated', AppActivatedEvent::class],
            ['installed', AppInstalledEvent::class],
            ['updated', AppUpdatedEvent::class],
        ];
    }

    public function eventDataWithoutContextProvider(): array
    {
        return [
            ['deactivated', AppDeactivatedEvent::class],
            ['deleted', AppUninstalledEvent::class],
        ];
    }
}
