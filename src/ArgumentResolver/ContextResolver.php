<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Factory\Context\ContextFactoryInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Vin\ShopwareSdk\Data\Context;

final class ContextResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private ShopRepositoryInterface $shopRepository,
        private ContextFactoryInterface $contextFactory,
        private ModelResolverInterface $modelResolver
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return Context::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        $shopId = match ($request->getMethod()) {
            'POST' => $this->modelResolver->resolve($request, Webhook::class)
                ->getSource()
                ->getShopId(),
            'GET' => $this->resolveShopIdFromRequestQuery($request),
            default => throw new MethodNotAllowedHttpException(['POST', 'GET']),
        };

        $shop = $this->shopRepository->getOneByShopId($shopId);

        yield $this->contextFactory->create($shop);
    }

    private function resolveShopIdFromRequestQuery(Request $request): string
    {
        return $request->query->get('shop-id', '');
    }
}
