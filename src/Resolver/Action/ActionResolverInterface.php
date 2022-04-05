<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Action;

use BitBag\ShopwareAppSystemBundle\Model\Action\Action;

interface ActionResolverInterface
{
    public function resolve(string $responseBody): Action;
}
