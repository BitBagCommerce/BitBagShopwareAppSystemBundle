<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Authenticator;

use Symfony\Component\HttpFoundation\Request;

final class Authenticator implements AuthenticatorInterface
{
    private string $appName;

    private string $appSecret;

    public function __construct(string $appName, string $appSecret)
    {
        $this->appName = $appName;
        $this->appSecret = $appSecret;
    }

    public function authenticateRegisterRequest(Request $request): bool
    {
        $signature = $request->headers->get('shopware-app-signature', '');
        $queryString = \rawurldecode($request->getQueryString() ?? '');

        $hmac = \hash_hmac('sha256', $queryString, $this->appSecret);

        return \hash_equals($hmac, $signature);
    }

    public function authenticatePostRequest(Request $request, string $shopSecret): bool
    {
        if (!array_key_exists('shopware-shop-signature', $request->headers->all())) {
            return false;
        }

        $signature = $request->headers->get('shopware-shop-signature', '');

        $hmac = \hash_hmac('sha256', $request->getContent(), $shopSecret);

        return \hash_equals($hmac, $signature);
    }

    public function authenticateGetRequest(Request $request, string $shopSecret): bool
    {
        $query = $request->query->all();

        /** @var string|null $shopSignature */
        $shopSignature = $query['shopware-shop-signature'];

        if (null === $shopSignature) {
            return false;
        }

        unset($query['shopware-shop-signature']);
        $queryString = \http_build_query($query);

        $hmac = \hash_hmac('sha256', $queryString, $shopSecret);

        return \hash_equals($hmac, $shopSignature);
    }
}
