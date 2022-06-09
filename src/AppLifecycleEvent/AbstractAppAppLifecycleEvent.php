<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Contracts\EventDispatcher\Event;
use Vin\ShopwareSdk\Data\Context;

abstract class AbstractAppAppLifecycleEvent extends Event implements AppLifecycleEventInterface
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
