<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\EventData;

use BitBag\ShopwareAppSystemBundle\Event\EventDataInterface;

interface EventDataResolverInterface
{
    /**
     * @return EventDataInterface[]
     */
    public function resolve(array $data): array;
}
