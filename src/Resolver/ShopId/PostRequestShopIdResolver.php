<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\ShopId;

use BitBag\ShopwareAppSystemBundle\Resolver\Request\RequestValueResolverInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\ShopSecret\GetValueNameTrait;
use Symfony\Component\HttpFoundation\Request;

final class PostRequestShopIdResolver implements RequestValueResolverInterface
{
    use GetValueNameTrait;

    private const VALUE_NAME = 'shop id';

    public function supports(Request $request): bool
    {
        return 'POST' === $request->getMethod();
    }

    public function resolve(Request $request): ?string
    {
        $requestContent = $request->toArray();

        /** @var array $source */
        $source = $requestContent['source'] ?? [];

        /** @var string $shopId */
        return $source['shopId'] ?? null;
    }
}
