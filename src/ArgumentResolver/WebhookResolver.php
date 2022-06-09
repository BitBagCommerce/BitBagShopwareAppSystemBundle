<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class WebhookResolver implements ArgumentValueResolverInterface
{
    public function __construct(private ModelResolverInterface $modelResolver)
    {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        return WebhookInterface::class === $argument->getType();
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->modelResolver->resolve($request, Webhook::class);
    }
}
