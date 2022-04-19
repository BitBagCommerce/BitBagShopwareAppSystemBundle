<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\LifecycleEvent\LifecycleEventInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

interface LifecycleEventFactoryInterface
{
    public function createNew(
        string $eventName,
        WebhookInterface $webhook,
        ?Context $context
    ): LifecycleEventInterface;
}
