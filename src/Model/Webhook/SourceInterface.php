<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

interface SourceInterface
{
    public function getUrl(): string;

    public function getAppVersion(): string;

    public function getShopId(): string;
}
