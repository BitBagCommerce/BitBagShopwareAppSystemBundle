<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\EventListener;

use BitBag\ShopwareAppSystemBundle\EventListener\RequestListener;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class RequestListenerTest extends TestCase
{
    public function testOnPostRequest(): void
    {
        $request = new Request();
        $request->headers->set('sw-user-language', 'en-GB');

        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            $request,
            null
        );

        $listener = new RequestListener();

        $listener->onKernelRequest($event);

        self::assertEquals('en', $request->getLocale());
    }

    public function testOnGetRequest(): void
    {
        $request = new Request();
        $request->query->set('sw-user-language', 'pl-PL');

        $event = new RequestEvent(
            $this->createMock(HttpKernelInterface::class),
            $request,
            null
        );

        $listener = new RequestListener();

        $listener->onKernelRequest($event);

        self::assertEquals('pl', $request->getLocale());
    }
}
