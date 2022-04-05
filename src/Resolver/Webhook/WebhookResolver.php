<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Factory\Serializer\SerializerFactoryInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class WebhookResolver implements WebhookResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerFactoryInterface $serializerFactory)
    {
        $this->serializer = $serializerFactory->create();
    }

    public function resolve(Request $request): Webhook
    {
        return $this->serializer->deserialize(
            $request->getContent(),
            Webhook::class,
            'json'
        );
    }
}
