<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use BitBag\ShopwareAppSystemBundle\Exception\UnresolvedContextException;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppActivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeactivatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppDeletedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppInstalledEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\AppUpdatedEvent;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\LifecycleEventInterface;
use Vin\ShopwareSdk\Data\Context;

final class LifecycleEventFactory implements LifecycleEventFactoryInterface
{
    public function createNew(string $eventName, EventInterface $event, ?Context $context): LifecycleEventInterface
    {
        switch ($eventName) {
            case 'deactivated':
                return new AppDeactivatedEvent($event);
            case 'deleted':
                return new AppDeletedEvent($event);
        }

        if ($context === null) {
            throw new UnresolvedContextException();
        }

        switch ($eventName) {
            case 'activated':
                return new AppActivatedEvent($event, $context);
            case 'installed':
                return new AppInstalledEvent($event, $context);
            case 'updated':
                return new AppUpdatedEvent($event, $context);
        }

        throw new \InvalidArgumentException(\sprintf("Wrong event name: %s.", $eventName));
    }
}
