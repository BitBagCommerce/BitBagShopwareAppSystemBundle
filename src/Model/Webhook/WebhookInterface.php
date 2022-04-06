<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

interface WebhookInterface
{
    public function getEvent(): EventInterface;

    public function getSource(): SourceInterface;

    public function getTimestamp(): int;
}
