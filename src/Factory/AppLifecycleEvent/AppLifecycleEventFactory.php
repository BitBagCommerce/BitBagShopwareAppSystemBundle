<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppActivatedEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppDeactivatedEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppInstalledEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppLifecycleEventInterface;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUninstalledEvent;
use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppUpdatedEvent;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

final class AppLifecycleEventFactory implements AppLifecycleEventFactoryInterface
{
    public function createNew(
        string $eventName,
        WebhookInterface $webhook,
        ?Context $context = null
    ): AppLifecycleEventInterface {
        $invalidArg = static fn (string $eventName): mixed => throw new \InvalidArgumentException(\sprintf('Invalid event name: %s.', $eventName));

        if (null !== $context) {
            return match ($eventName) {
                'activated' => new AppActivatedEvent($webhook, $context),
                'installed' => new AppInstalledEvent($webhook, $context),
                'updated' => new AppUpdatedEvent($webhook, $context),
                default => $invalidArg($eventName)
            };
        }

        return match ($eventName) {
            'deactivated' => new AppDeactivatedEvent($webhook),
            'deleted' => new AppUninstalledEvent($webhook),
            default => $invalidArg($eventName)
        };
    }
}
