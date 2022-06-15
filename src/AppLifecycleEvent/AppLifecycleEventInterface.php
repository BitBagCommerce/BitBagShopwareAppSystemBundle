<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;

interface AppLifecycleEventInterface
{
    public function getWebhook(): WebhookInterface;
}
