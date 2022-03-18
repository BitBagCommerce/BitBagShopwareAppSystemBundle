<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\ShopId;

use BitBag\ShopwareAppSystemBundle\Resolver\Request\RequestValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;

final class PostRequestShopIdResolver implements RequestValueResolverInterface
{
    public function supports(Request $request): bool
    {
        return 'POST' === $request->getMethod();
    }

    public function resolve(Request $request): ?string
    {
        $requestContent = $request->toArray();

        /** @var array $source */
        $source = $requestContent['source'] ?? [];

        return $source['shopId'] ?? null;
    }
}
