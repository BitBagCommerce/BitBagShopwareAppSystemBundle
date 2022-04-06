<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Source;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\SourceInterface;

/** @psalm-suppress MissingConstructor */
final class Action implements ActionInterface
{
    private SourceInterface $source;

    private Meta $meta;

    private Data $data;

    public function getSource(): SourceInterface
    {
        return $this->source;
    }

    public function setSource(Source $source): void
    {
        $this->source = $source;
    }

    public function getMeta(): MetaInterface
    {
        return $this->meta;
    }

    public function setMeta(Meta $meta): void
    {
        $this->meta = $meta;
    }

    public function getData(): DataInterface
    {
        return $this->data;
    }

    public function setData(Data $data): void
    {
        $this->data = $data;
    }
}
