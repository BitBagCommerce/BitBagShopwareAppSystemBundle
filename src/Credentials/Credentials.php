<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Credentials;

final class Credentials implements CredentialsInterface
{
    private string $shopUrl;

    private string $apiKey;

    private string $secretKey;

    private ?string $token;

    public function __construct(string $shopUrl, string $key, string $secretKey, ?string $token = null)
    {
        $this->shopUrl = $shopUrl;
        $this->apiKey = $key;
        $this->secretKey = $secretKey;
        $this->token = $token;
    }

    public function getShopUrl(): string
    {
        return $this->shopUrl;
    }

    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    public function getSecretKey(): string
    {
        return $this->secretKey;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function withToken(string $token): CredentialsInterface
    {
        return new self(
            $this->shopUrl,
            $this->apiKey,
            $this->secretKey,
            $this->token
        );
    }
}
