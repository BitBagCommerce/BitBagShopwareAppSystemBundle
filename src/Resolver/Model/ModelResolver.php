<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Model;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\SerializerInterface;

final class ModelResolver implements ModelResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(Request $request, string $class): mixed
    {
        return $this->serializer->deserialize(
            $request->getContent(),
            $class,
            'json'
        );
    }
}
