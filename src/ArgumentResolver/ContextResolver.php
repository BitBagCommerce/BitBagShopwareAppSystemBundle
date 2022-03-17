<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Authenticator\AuthenticatorInterface;
use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Request\AggregateRequestValueResolverInterface;
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

    private AggregateRequestValueResolverInterface $shopSecretResolver;

    private AggregateRequestValueResolverInterface $shopIdResolver;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        AuthenticatorInterface $authenticator,
        AggregateRequestValueResolverInterface $shopSecretResolver,
        AggregateRequestValueResolverInterface $shopIdResolver
    ) {
        $this->shopRepository = $shopRepository;
        $this->authenticator = $authenticator;
        $this->shopSecretResolver = $shopSecretResolver;
        $this->shopIdResolver = $shopIdResolver;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (Context::class !== $argument->getType()) {
            return false;
        }

        $shopSecret = $this->shopSecretResolver->resolve($request);

        switch ($request->getMethod()) {
            case 'POST':
                return $this->authenticator->authenticatePostRequest($request, $shopSecret);
            case 'GET':
                return $this->authenticator->authenticateGetRequest($request, $shopSecret);
        }

        return false;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $shopId = $this->shopIdResolver->resolve($request);

        $shop = $this->shopRepository->getOneByShopId($shopId);

        yield $this->getContext($shop);
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
