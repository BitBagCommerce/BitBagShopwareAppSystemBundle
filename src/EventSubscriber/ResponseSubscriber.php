<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\Model\Action\Action;
use BitBag\ShopwareAppSystemBundle\Model\Action\ActionInterface;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolverInterface;
use BitBag\ShopwareAppSystemBundle\Response\FeedbackResponse;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponseSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private ShopRepositoryInterface $shopRepository,
        private ModelResolverInterface $modelResolver
    ) {
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
        /** @var ActionInterface $action */
        $action = $this->modelResolver->resolve($request, Action::class);
        $shopId = $action->getSource()->getShopId();
        $shop = $this->shopRepository->getOneByShopId($shopId);

        $hmac = \hash_hmac('sha256', (string) $response->getContent(), $shop->getShopSecret());

        $response->headers->set('shopware-app-signature', $hmac);
    }
}
