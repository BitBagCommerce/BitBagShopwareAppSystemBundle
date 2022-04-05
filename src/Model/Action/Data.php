<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

/** @psalm-suppress MissingConstructor */
final class Data
{
    private array $ids;

    private string $entity;

    private string $action;

    public function getIds(): array
    {
        return $this->ids;
    }

    public function setIds(array $ids): void
    {
        $this->ids = $ids;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }
}
