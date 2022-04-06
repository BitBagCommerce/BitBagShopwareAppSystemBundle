<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class WebhookResolver implements WebhookResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(Request $request): WebhookInterface
    {
        return $this->serializer->deserialize(
            $request->getContent(),
            Webhook::class,
            'json'
        );
    }
}
