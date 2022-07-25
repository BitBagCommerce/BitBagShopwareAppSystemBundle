<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\Context;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use Symfony\Component\HttpFoundation\Request;
use Vin\ShopwareSdk\Client\AdminAuthenticator;
use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Defaults;
use Vin\ShopwareSdk\Exception\AuthorizationFailedException;

final class ContextFactory implements ContextFactoryInterface
{
    public function create(ShopInterface $shop, Request $request): ?Context
    {
        $authenticator = new AdminAuthenticator(new ClientCredentialsGrantType(
            $shop->getApiKey() ?? '',
            $shop->getSecretKey() ?? ''
        ), $shop->getShopUrl());

        try {
            $token = $authenticator->fetchAccessToken();
        } catch (AuthorizationFailedException) {
            return null;
        }

        $languageId = $request->headers->get('sw-context-language');
        $shopwareVersion = $request->headers->get('sw-version');

        return new Context(
            $shop->getShopUrl(),
            $token,
            $languageId ?? Defaults::LANGUAGE_SYSTEM,
            Defaults::CURRENCY,
            $shopwareVersion ?? Defaults::LIVE_VERSION
        );
    }
}
