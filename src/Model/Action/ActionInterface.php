<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Action;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\SourceInterface;

interface ActionInterface
{
    public function getSource(): SourceInterface;

    public function getMeta(): MetaInterface;

    public function getData(): DataInterface;
}
