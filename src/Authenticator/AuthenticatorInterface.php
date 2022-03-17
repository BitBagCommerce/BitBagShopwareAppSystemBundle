<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Authenticator;

use Symfony\Component\HttpFoundation\Request;

interface AuthenticatorInterface
{
    public function authenticateRegisterRequest(Request $request): bool;

    public function authenticatePostRequest(Request $request, string $shopSecret): bool;

    public function authenticateGetRequest(Request $request, string $shopSecret): bool;
}
