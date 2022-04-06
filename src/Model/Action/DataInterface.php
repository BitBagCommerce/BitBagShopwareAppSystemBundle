<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

interface DataInterface
{
    public function getIds(): array;

    public function getEntity(): string;

    public function getAction(): string;
}
