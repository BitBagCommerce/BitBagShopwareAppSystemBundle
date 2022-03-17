<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\Request;

use BitBag\ShopwareAppSystemBundle\Exception\UnresolvedRequestDataException;
use Symfony\Component\HttpFoundation\Request;

final class AggregateRequestValueResolver implements AggregateRequestValueResolverInterface
{
    private iterable $resolvers;
    private string $valueName;

    public function __construct(iterable $resolvers, string $valueName)
    {
        $this->resolvers = $resolvers;
        $this->valueName = $valueName;
    }

    public function resolve(Request $request): string
    {
        $value = null;

        /** @var RequestValueResolverInterface $resolver */
        foreach ($this->resolvers as $resolver) {
            if (!$resolver->supports($request)) {
                continue;
            }

            $value = $resolver->resolve($request);
        }

        if (null === $value) {
            throw new UnresolvedRequestDataException($this->valueName);
        }

        return $value;
    }
}
