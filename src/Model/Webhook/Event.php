<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

/** @psalm-suppress MissingConstructor */
final class Event
{
    /** @var Payload[] */
    private array $payload;

    private string $event;

    /**
     * @return Payload[]
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function setEvent(string $event): void
    {
        $this->event = $event;
    }
}
