<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Action;

use BitBag\ShopwareAppSystemBundle\Model\Action\Action;
use Symfony\Component\Serializer\SerializerInterface;

final class ActionResolver implements ActionResolverInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public function resolve(string $responseBody): Action
    {
        return $this->serializer->deserialize(
            $responseBody,
            Action::class,
            'json'
        );
    }
}
