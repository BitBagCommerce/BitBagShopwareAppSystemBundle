<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Request;

use Symfony\Component\HttpFoundation\Request;

interface RequestValueResolverInterface
{
    public function supports(Request $request): bool;

    public function resolve(Request $request): ?string;

    public function getValueName(): string;
}
