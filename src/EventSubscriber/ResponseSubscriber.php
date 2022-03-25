<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventSubscriber;

use BitBag\ShopwareAppSystemBundle\Controller\SignedControllerInterface;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Request\AggregateRequestValueResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ResponseSubscriber implements EventSubscriberInterface
{
    private const SIGNED_CONTROLLER_ATTRIBUTE = 'bitbag.shopware_app_system.signed_controller';

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
            KernelEvents::CONTROLLER => 'onControllerEvent',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onControllerEvent(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if (is_array($controller)) {
            $controller = $controller[0];
        }

        if (!$controller instanceof SignedControllerInterface) {
            return;
        }

        $request = $event->getRequest();

        if ('POST' !== $request->getMethod()) {
            return;
        }

        $event->getRequest()->attributes->set(self::SIGNED_CONTROLLER_ATTRIBUTE, true);
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $attributeValue = $request->attributes->get(self::SIGNED_CONTROLLER_ATTRIBUTE, false);

        if (!$attributeValue) {
            return;
        }

        $response = $event->getResponse();

        $shopId = $this->shopIdResolver->resolve($request);
        $shop = $this->shopRepository->getOneByShopId($shopId);

        $hmac = hash_hmac('sha256', (string) $response->getContent(), $shop->getShopSecret());

        $response->headers->set('shopware-app-signature', $hmac);
    }
}
