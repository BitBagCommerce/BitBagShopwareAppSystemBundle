<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\Context;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use Vin\ShopwareSdk\Data\Context;

interface ContextFactoryInterface
{
    public function create(ShopInterface $shop): ?Context;
}
