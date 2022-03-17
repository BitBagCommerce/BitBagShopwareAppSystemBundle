<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Request;

use Symfony\Component\HttpFoundation\Request;

interface AggregateRequestValueResolverInterface
{
    public function resolve(Request $request): string;
}
