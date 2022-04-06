<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

/** @psalm-suppress MissingConstructor */
final class Meta implements MetaInterface
{
    private int $timestamp;

    private string $reference;

    private string $language;

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    public function getReference(): string
    {
        return $this->reference;
    }

    public function setReference(string $reference): void
    {
        $this->reference = $reference;
    }

    public function getLanguage(): string
    {
        return $this->language;
    }

    public function setLanguage(string $language): void
    {
        $this->language = $language;
    }
}
