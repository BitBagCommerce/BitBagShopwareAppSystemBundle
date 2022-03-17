<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use Vin\ShopwareSdk\Data\Context;

abstract class AbstractContextAwareLifecycleEvent extends AbstractLifecycleEvent implements ContextAwareLifecycleEventInterface
{
    private Context $context;

    public function __construct(EventInterface $event, Context $context)
    {
        $this->context = $context;

        parent::__construct($event);
    }

    public function getContext(): Context
    {
        return $this->context;
    }
}
