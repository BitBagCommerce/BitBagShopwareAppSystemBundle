<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;

interface LifecycleEventInterface
{
    public function getWebhook(): WebhookInterface;
}
