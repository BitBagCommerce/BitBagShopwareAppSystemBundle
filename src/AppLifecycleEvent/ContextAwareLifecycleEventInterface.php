<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\AppLifecycleEvent;

use Vin\ShopwareSdk\Data\Context;

interface ContextAwareLifecycleEventInterface
{
    public function getContext(): Context;
}
