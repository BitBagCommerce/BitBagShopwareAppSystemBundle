<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

/** @psalm-suppress MissingConstructor */
final class Source implements SourceInterface
{
    private string $url;

    private string $appVersion;

    private string $shopId;

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getAppVersion(): string
    {
        return $this->appVersion;
    }

    public function setAppVersion(string $appVersion): void
    {
        $this->appVersion = $appVersion;
    }

    public function getShopId(): string
    {
        return $this->shopId;
    }

    public function setShopId(string $shopId): void
    {
        $this->shopId = $shopId;
    }
}
