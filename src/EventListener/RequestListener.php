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

        $userLanguage = $request->headers->get(self::KEY_NAME) ?? $request->query->get(self::KEY_NAME);

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
