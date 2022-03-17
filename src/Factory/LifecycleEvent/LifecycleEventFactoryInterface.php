<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use BitBag\ShopwareAppSystemBundle\LifecycleEvent\LifecycleEventInterface;
use Vin\ShopwareSdk\Data\Context;

interface LifecycleEventFactoryInterface
{
    public function createNew(
        string $eventName,
        EventInterface $event,
        ?Context $context
    ): LifecycleEventInterface;
}
