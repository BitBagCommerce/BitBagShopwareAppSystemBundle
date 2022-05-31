<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Model;

use Symfony\Component\HttpFoundation\Request;

interface ModelResolverInterface
{
    public function resolve(Request $request, string $class): mixed;
}
