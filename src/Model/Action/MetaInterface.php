<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

interface MetaInterface
{
    public function getTimestamp(): int;

    public function getReference(): string;

    public function getLanguage(): string;
}
