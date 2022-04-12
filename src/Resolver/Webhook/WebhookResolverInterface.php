<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;

interface WebhookResolverInterface
{
    public function resolve(string $responseBody): WebhookInterface;
}
