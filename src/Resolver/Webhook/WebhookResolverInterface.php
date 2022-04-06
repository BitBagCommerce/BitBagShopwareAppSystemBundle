<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Component\HttpFoundation\Request;

interface WebhookResolverInterface
{
    public function resolve(Request $request): WebhookInterface;
}
