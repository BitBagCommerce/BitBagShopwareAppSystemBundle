<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Webhook;

use Symfony\Component\Serializer\Annotation\SerializedName;

/** @psalm-suppress MissingConstructor */
final class Webhook implements WebhookInterface
{
    /** @SerializedName("data") */
    private Event $event;

    private SourceInterface $source;

    private int $timestamp;

    public function getEvent(): EventInterface
    {
        return $this->event;
    }

    public function setEvent(Event $event): void
    {
        $this->event = $event;
    }

    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }

    public function getTimestamp(): int
    {
        return $this->timestamp;
    }

    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}
