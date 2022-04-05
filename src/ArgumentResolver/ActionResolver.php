<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Authenticator\AuthenticatorInterface;
use BitBag\ShopwareAppSystemBundle\Model\Action\Action;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Action\ActionResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class ActionResolver implements ArgumentValueResolverInterface
{
    private ActionResolverInterface $actionResolver;

    private ShopRepositoryInterface $shopRepository;

    private AuthenticatorInterface $authenticator;

    public function __construct(
        ActionResolverInterface $actionResolver,
        ShopRepositoryInterface $shopRepository,
        AuthenticatorInterface $authenticator
    ) {
        $this->actionResolver = $actionResolver;
        $this->shopRepository = $shopRepository;
        $this->authenticator = $authenticator;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (Action::class !== $argument->getType()) {
            return false;
        }

        $json = $request->toArray();

        $shopId = $json['source']['shopId'];

        $shopSecret = $this->shopRepository->findSecretByShopId($shopId);

        if (null === $shopSecret) {
            return false;
        }

        return $this->authenticator->authenticatePostRequest($request, $shopSecret);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->actionResolver->resolve($request->getContent());
    }
}
