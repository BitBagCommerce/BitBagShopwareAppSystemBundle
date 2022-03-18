<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Event;

final class EventData implements EventDataInterface
{
    private ?string $entity;

    private ?string $operation;

    private ?string $primaryKey;

    private array $updatedFields = [];

    private string $event;

    private array $payload;

    public function __construct(
        ?string $entity,
        ?string $operation,
        ?string $primaryKey,
        array $updatedFields,
        string $event,
        array $payload
    ) {
        $this->entity = $entity;
        $this->operation = $operation;
        $this->primaryKey = $primaryKey;
        $this->updatedFields = $updatedFields;
        $this->event = $event;
        $this->payload = $payload;
    }

    public function getEntity(): ?string
    {
        return $this->entity;
    }

    public function getOperation(): ?string
    {
        return $this->operation;
    }

    public function getPrimaryKey(): ?string
    {
        return $this->primaryKey;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }

    public function getEvent(): string
    {
        return $this->event;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }
}
