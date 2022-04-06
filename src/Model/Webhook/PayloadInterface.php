<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

interface PayloadInterface
{
    public function getEntity(): string;

    public function getOperation(): string;

    public function getPrimaryKey(): string;

    public function getUpdatedFields(): array;
}
