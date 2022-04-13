<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Request\AggregateRequestValueResolverInterface;
use BitBag\ShopwareAppSystemBundle\Response\FeedbackResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponseSubscriber implements EventSubscriberInterface
{
    private ShopRepositoryInterface $shopRepository;

    private AggregateRequestValueResolverInterface $shopIdResolver;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        AggregateRequestValueResolverInterface $shopIdResolver
    ) {
        $this->shopRepository = $shopRepository;
        $this->shopIdResolver = $shopIdResolver;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $response = $event->getResponse();

        if (!$response instanceof FeedbackResponse) {
            return;
        }

        $request = $event->getRequest();
        $shopId = $this->shopIdResolver->resolve($request);
        $shop = $this->shopRepository->getOneByShopId($shopId);

        $hmac = hash_hmac('sha256', (string) $response->getContent(), $shop->getShopSecret());

        $response->headers->set('shopware-app-signature', $hmac);
    }
}
