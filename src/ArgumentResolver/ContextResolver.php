<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Authenticator\AuthenticatorInterface;
use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Vin\ShopwareSdk\Client\AdminAuthenticator;
use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Exception\AuthorizationFailedException;

final class ContextResolver implements ArgumentValueResolverInterface
{
    private ShopRepositoryInterface $shopRepository;

    private AuthenticatorInterface $authenticator;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        AuthenticatorInterface $authenticator
    ) {
        $this->shopRepository = $shopRepository;
        $this->authenticator = $authenticator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (Context::class !== $argument->getType()) {
            return false;
        }

        if ('POST' === $request->getMethod() && $this->supportsPostRequest($request)) {
            $requestContent = $request->toArray();

            /** @var array $source */
            $source = $requestContent['source'];

            /** @var string $shopId */
            $shopId = $source['shopId'];

            $shopSecret = $this->shopRepository->findSecretByShopId($shopId);

            if (null === $shopSecret) {
                return false;
            }

            return $this->authenticator->authenticatePostRequest($request, $shopSecret);
        } elseif ('GET' === $request->getMethod() && $this->supportsGetRequest($request)) {
            $shopId = $request->query->get('shop-id', '');
            $shopSecret = $this->shopRepository->findSecretByShopId($shopId);

            if (null === $shopSecret) {
                return false;
            }

            return $this->authenticator->authenticateGetRequest($request, $shopSecret);
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        if ('POST' === $request->getMethod()) {
            $requestContent = $request->toArray();

            /** @var array $source */
            $source = $requestContent['source'];

            /** @var string $shopId */
            $shopId = $source['shopId'];
        } else {
            /** @var string $shopId */
            $shopId = $request->query->get('shop-id');
        }

        $shop = $this->shopRepository->getOneByShopId($shopId);

        yield $this->getContext($shop);
    }

    private function supportsPostRequest(Request $request): bool
    {
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

    private function supportsGetRequest(Request $request): bool
    {
        $query = $request->query->all();

        $requiredKeys = ['shop-url', 'shop-id', 'shopware-shop-signature', 'timestamp'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $query)) {
                return false;
            }
        }

        return true;
    }

    private function getContext(ShopInterface $shop): ?Context
    {
        $authenticator = new AdminAuthenticator(new ClientCredentialsGrantType(
            $shop->getApiKey() ?? '',
            $shop->getSecretKey() ?? ''
        ), $shop->getShopUrl());

        try {
            $token = $authenticator->fetchAccessToken();
        } catch (AuthorizationFailedException $e) {
            return null;
        }

        return new Context(
            $shop->getShopUrl(),
            $token
        );
    }
}
