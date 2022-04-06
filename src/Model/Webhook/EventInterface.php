<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

interface EventInterface
{
    /**
     * @return PayloadInterface[]
     */
    public function getPayload(): array;

    public function getEvent(): string;
}
