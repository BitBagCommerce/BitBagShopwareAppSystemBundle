<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Event;

interface EventInterface
{
    public function getShopUrl(): string;

    public function getShopId(): string;

    public function getAppVersion(): int;

    /**
     * @return EventDataInterface[]
     */
    public function getEventData(): array;

    public function getSingleEventData(): EventDataInterface;
}
