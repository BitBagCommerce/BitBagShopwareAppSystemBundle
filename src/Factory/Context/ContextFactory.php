<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Factory\Context;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use Vin\ShopwareSdk\Client\AdminAuthenticator;
use Vin\ShopwareSdk\Client\GrantType\ClientCredentialsGrantType;
use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Exception\AuthorizationFailedException;

final class ContextFactory implements ContextFactoryInterface
{
    public function create(ShopInterface $shop): ?Context
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

        return new Context(
            $shop->getShopUrl(),
            $token
        );
    }
}
