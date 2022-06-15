<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Vin\ShopwareSdk\Data\Context;

abstract class AbstractAppLifecycleEvent extends Event implements AppLifecycleEventInterface, ContextAwareLifecycleEventInterface
{
    public function __construct(
        private WebhookInterface $webhook,
        private Context $context
    ) {
    }

    public function getWebhook(): WebhookInterface
    {
        return $this->webhook;
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
