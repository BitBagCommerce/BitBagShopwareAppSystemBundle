<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use Symfony\Contracts\EventDispatcher\Event;

abstract class AbstractLifecycleEvent extends Event implements LifecycleEventInterface
{
    private EventInterface $event;

    public function __construct(EventInterface $event)
    {
        $this->event = $event;
    }

    public function getShopwareEvent(): EventInterface
    {
        return $this->event;
    }
}
