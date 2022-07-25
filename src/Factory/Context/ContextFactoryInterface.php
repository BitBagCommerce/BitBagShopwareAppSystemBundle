<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\Context;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use Symfony\Component\HttpFoundation\Request;
use Vin\ShopwareSdk\Data\Context;

interface ContextFactoryInterface
{
    public function create(ShopInterface $shop, Request $request): ?Context;
}
