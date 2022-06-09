<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

interface AppLifecycleEventInterface
{
    public function getWebhook(): WebhookInterface;

    public function getContext(): Context;
}
