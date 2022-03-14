<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use BitBag\ShopwareAppSystemBundle\Event\EventInterface;

interface LifecycleEventInterface
{
    public function getShopwareEvent(): EventInterface;
}
