<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Action;

use BitBag\ShopwareAppSystemBundle\Model\Action\ActionInterface;

interface ActionResolverInterface
{
    public function resolve(string $responseBody): ActionInterface;
}
