<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\ArgumentResolver;

use BitBag\ShopwareAppSystemBundle\Authenticator\AuthenticatorInterface;
use BitBag\ShopwareAppSystemBundle\Event\Event;
use BitBag\ShopwareAppSystemBundle\Event\EventInterface;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\EventData\EventDataResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

final class EventResolver implements ArgumentValueResolverInterface
{
    private ShopRepositoryInterface $shopRepository;

    private AuthenticatorInterface $authenticator;

    private EventDataResolverInterface $eventDataResolver;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        AuthenticatorInterface $authenticator,
        EventDataResolverInterface $eventDataResolver
    ) {
        $this->shopRepository = $shopRepository;
        $this->authenticator = $authenticator;
        $this->eventDataResolver = $eventDataResolver;
    }

    /* @psalm-suppress PossiblyUndefinedArrayOffset */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        if (EventInterface::class !== $argument->getType()) {
            return false;
        }

        if ('POST' !== $request->getMethod()) {
            return false;
        }

        $requestContent = $request->toArray();

        $hasSource = array_key_exists('source', $requestContent);
        $hasData = array_key_exists('data', $requestContent);
        $hasSourceAndData = $hasSource && $hasData;

        if (!$hasSourceAndData) {
            return false;
        }

        $requiredKeys = ['url', 'appVersion', 'shopId'];
        $requestSource = $requestContent['source'];

        foreach ($requiredKeys as $key) {
            if (!array_key_exists($key, $requestSource)) {
                return false;
            }
        }

        $shopSecret = $this->shopRepository->findSecretByShopId($requestContent['source']['shopId']);

        if (null === $shopSecret) {
            return false;
        }

        return $this->authenticator->authenticatePostRequest($request, $shopSecret);
    }

    public function resolve(Request $request, ArgumentMetadata $argument): \Generator
    {
        /** @psalm-var array{
         *     source: array{
         *          url: string,
         *          appVersion: string,
         *          shopId: string
         *      },
         *     data: array
         * } $requestContent
         */
        $requestContent = $request->toArray();

        $shopUrl = $requestContent['source']['url'];
        $shopId = $requestContent['source']['shopId'];
        $appVersion = (int) $requestContent['source']['appVersion'];
        $eventData = $this->eventDataResolver->resolve($requestContent['data']);

        yield new Event($shopUrl, $shopId, $appVersion, $eventData);
    }
}
