<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\ShopSecret;

use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Request\RequestValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;

final class GetRequestShopSecretResolver implements RequestValueResolverInterface
{
    private ShopRepositoryInterface $shopRepository;

    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function resolve(Request $request): ?string
    {
        $shopId = $request->query->get('shop-id', '');

        return $this->shopRepository->findSecretByShopId($shopId);
    }

    public function supports(Request $request): bool
    {
        if ('GET' !== $request->getMethod()) {
            return false;
        }

        $query = $request->query->all();

        $requiredKeys = ['shop-url', 'shop-id', 'shopware-shop-signature', 'timestamp'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $query)) {
                return false;
            }
        }

        return true;
    }
}
