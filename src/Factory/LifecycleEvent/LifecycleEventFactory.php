<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Exception\UnresolvedContextException;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppActivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeactivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeletedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppInstalledEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppUpdatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\LifecycleEventInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

final class LifecycleEventFactory implements LifecycleEventFactoryInterface
{
    public function createNew(
        string $eventName,
        WebhookInterface $webhook,
        ?Context $context
    ): LifecycleEventInterface {
        switch ($eventName) {
            case 'deactivated':
                return new AppDeactivatedEvent($webhook);
            case 'deleted':
                return new AppDeletedEvent($webhook);
        }

        if (null === $context) {
            throw new UnresolvedContextException();
        }

        switch ($eventName) {
            case 'activated':
                return new AppActivatedEvent($webhook, $context);
            case 'installed':
                return new AppInstalledEvent($webhook, $context);
            case 'updated':
                return new AppUpdatedEvent($webhook, $context);
        }

        throw new \InvalidArgumentException(\sprintf('Invalid event name: %s.', $eventName));
    }
}
