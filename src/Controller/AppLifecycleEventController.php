<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Controller;

use BitBag\ShopwareAppSystemBundle\Factory\LifecycleEvent\LifecycleEventFactoryInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\WebhookInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Vin\ShopwareSdk\Data\Context;

final class AppLifecycleEventController
{
    private EventDispatcherInterface $eventDispatcher;

    private LifecycleEventFactoryInterface $eventFactory;

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        LifecycleEventFactoryInterface $eventFactory
    ) {
        $this->eventDispatcher = $eventDispatcher;
        $this->eventFactory = $eventFactory;
    }

    public function __invoke(
        WebhookInterface $webhook,
        string $eventType,
        ?Context $context
    ): Response {
        $event = $this->eventFactory->createNew($eventType, $webhook, $context);

        $this->eventDispatcher->dispatch($event);

        return new Response();
    }
}
