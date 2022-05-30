<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestListener
{
    public const HEADER_NAME = 'sw-user-language';

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $userLanguageHeader = $request->headers->get(self::HEADER_NAME);

        if (null === $userLanguageHeader) {
            return;
        }

        $isoPair = \explode('-', $userLanguageHeader);
        $languageIsoCode = $isoPair[0] ?? null;

        if (null !== $languageIsoCode) {
            $request->setLocale($languageIsoCode);
        }
    }
}
