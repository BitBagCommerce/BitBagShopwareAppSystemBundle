<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Webhook\WebhookResolver as RequestWebhookResolver;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class WebhookResolver implements ArgumentValueResolverInterface
{
    private RequestWebhookResolver $webhookResolver;

    public function __construct(RequestWebhookResolver $webhookResolver)
    {
        $this->webhookResolver = $webhookResolver;
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (WebhookInterface::class !== $argument->getType()) {
            return false;
        }

        if ('POST' !== $request->getMethod()) {
            return false;
        }

        return true;
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        yield $this->webhookResolver->resolve($request->getContent());
    }
}
