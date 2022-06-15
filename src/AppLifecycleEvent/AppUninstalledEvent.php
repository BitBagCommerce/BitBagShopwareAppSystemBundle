<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;

final class AppUninstalledEvent implements AppLifecycleEventInterface
{
    public function __construct(private WebhookInterface $webhook)
    {
    }

    public function getWebhook(): WebhookInterface
    {
        return $this->webhook;
    }
}
