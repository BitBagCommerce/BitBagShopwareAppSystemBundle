<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

/** @psalm-suppress MissingConstructor */
final class Payload
{
    private string $entity;

    private string $operation;

    private string $primaryKey;

    /** @var string[] */
    private array $updatedFields;

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    public function getOperation(): string
    {
        return $this->operation;
    }

    public function setOperation(string $operation): void
    {
        $this->operation = $operation;
    }

    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    public function setPrimaryKey(string $primaryKey): void
    {
        $this->primaryKey = $primaryKey;
    }

    public function getUpdatedFields(): array
    {
        return $this->updatedFields;
    }

    public function setUpdatedFields(array $updatedFields): void
    {
        $this->updatedFields = $updatedFields;
    }
}
