<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;

final class RequestListener
{
    public const KEY_NAME = 'sw-user-language';

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        $userLanguage = match ($request->getMethod()) {
            'POST' => $request->headers->get(self::KEY_NAME),
            'GET' => $request->query->get(self::KEY_NAME),
            default => null
        };

        if (null === $userLanguage) {
            return;
        }

        $isoPair = \explode('-', $userLanguage);
        $languageIsoCode = $isoPair[0] ?? null;

        if (null !== $languageIsoCode) {
            $request->setLocale($languageIsoCode);
        }
    }
}
