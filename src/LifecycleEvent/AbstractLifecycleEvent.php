<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractLifecycleEvent extends Event implements LifecycleEventInterface
{
    private WebhookInterface $webhook;

    public function __construct(WebhookInterface $webhook)
    {
        $this->webhook = $webhook;
    }

    public function getWebhook(): WebhookInterface
    {
        return $this->webhook;
    }
}
