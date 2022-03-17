<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\LifecycleEvent;

use Vin\ShopwareSdk\Data\Context;

interface ContextAwareLifecycleEventInterface extends LifecycleEventInterface
{
    public function getContext(): Context;
}
