<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\ShopSecret;

use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Request\RequestValueResolverInterface;
use Symfony\Component\HttpFoundation\Request;

final class PostRequestShopSecretResolver implements RequestValueResolverInterface
{
    use GetValueNameTrait;

    private ShopRepositoryInterface $shopRepository;

    public function __construct(ShopRepositoryInterface $shopRepository)
    {
        $this->shopRepository = $shopRepository;
    }

    public function resolve(Request $request): ?string
    {
        $requestContent = $request->toArray();

        /** @var array $source */
        $source = $requestContent['source'];

        /** @var string $shopId */
        $shopId =  $source['shopId'] ?? '';

        return $this->shopRepository->findSecretByShopId($shopId);
    }

    public function supports(Request $request): bool
    {
        if ($request->getMethod() !== 'POST') {
            return false;
        }

        /** @var array{source?: array} $requestContent */
        $requestContent = $request->toArray();

        $hasSource = $requestContent && array_key_exists('source', $requestContent);

        if (!$hasSource) {
            return false;
        }

        $requiredKeys = ['url', 'shopId'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $requestContent['source'])) {
                return false;
            }
        }

        return true;
    }
}
