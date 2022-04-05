<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\Serializer;

use Symfony\Component\Serializer\SerializerInterface;

interface SerializerFactoryInterface
{
    public function create(): SerializerInterface;
}
