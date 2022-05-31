<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Model\Action\Action;
use BitBag\ShopwareAppSystemBundle\Model\Action\ActionInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class ActionResolver implements ArgumentValueResolverInterface
{
    private ModelResolverInterface $modelResolver;

    public function __construct(
        ModelResolverInterface $modelResolver
    ) {
        $this->modelResolver = $modelResolver;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return ActionInterface::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->modelResolver->resolve($request, Action::class);
    }
}
