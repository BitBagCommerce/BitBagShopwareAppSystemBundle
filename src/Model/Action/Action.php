<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Source;

/** @psalm-suppress MissingConstructor */
final class Action
{
    private Source $source;

    private Meta $meta;

    private Data $data;

    public function getSource(): Source
    {
        return $this->source;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }

    public function getMeta(): Meta
    {
        return $this->meta;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function getData(): Data
    {
        return $this->data;
    }

    public function setData(Data $data): void
    {
        $this->data = $data;
    }
}
