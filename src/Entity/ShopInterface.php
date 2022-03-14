<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Entity;

interface ShopInterface
{
    public function getShopId(): string;

    public function setShopId(string $shopId): void;

    public function getShopUrl(): string;

    public function setShopUrl(string $shopUrl): void;

    public function getShopSecret(): string;

    public function setShopSecret(string $shopSecret): void;

    public function getApiKey(): ?string;

    public function setApiKey(?string $apiKey): void;

    public function getSecretKey(): ?string;

    public function setSecretKey(?string $secretKey): void;
}
