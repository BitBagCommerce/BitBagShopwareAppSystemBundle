<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\AppLifecycleEvent\AppLifecycleEventInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

interface AppLifecycleEventFactoryInterface
{
    public function createNew(
        string $eventName,
        WebhookInterface $webhook,
        Context $context
    ): AppLifecycleEventInterface;
}
