<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Event;

interface EventDataInterface
{
    public function getEntity(): ?string;

    public function getOperation(): ?string;

    public function getPrimaryKey(): ?string;

    public function getUpdatedFields(): array;

    public function getEvent(): string;

    public function getPayload(): array;
}
