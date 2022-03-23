<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\ShopId;

use BitBag\ShopwareAppSystemBundle\Resolver\Request\RequestValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;

final class GetRequestShopIdResolver implements RequestValueResolverInterface
{
    public function supports(Request $request): bool
    {
        return 'GET' === $request->getMethod();
    }

    public function resolve(Request $request): ?string
    {
        return $request->query->get('shop-id', null);
    }
}