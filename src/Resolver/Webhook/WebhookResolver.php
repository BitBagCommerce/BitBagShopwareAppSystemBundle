<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Component\Serializer\SerializerInterface;

final class WebhookResolver implements WebhookResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(string $responseBody): WebhookInterface
    {
        return $this->serializer->deserialize(
            $responseBody,
            Webhook::class,
            'json'
        );
    }
}
