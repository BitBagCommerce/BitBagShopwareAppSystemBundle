<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Vin\ShopwareSdk\Data\Context;

abstract class AbstractContextAwareLifecycleEvent extends AbstractLifecycleEvent implements ContextAwareLifecycleEventInterface
{
    private Context $context;

    public function __construct(WebhookInterface $webhook, Context $context)
    {
        $this->context = $context;

        parent::__construct($webhook);
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
