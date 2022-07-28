<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EntityDefinition;

use Vin\ShopwareSdk\Data\Entity\Custom\CustomCollection;
use Vin\ShopwareSdk\Data\Entity\Custom\CustomEntity;
use Vin\ShopwareSdk\Data\Entity\EntityDefinition;
use Vin\ShopwareSdk\Data\Schema\PropertyCollection;
use Vin\ShopwareSdk\Data\Schema\Schema;

abstract class AbstractCustomEntityDefinition implements EntityDefinition
{
    public function getEntityClass(): string
    {
        return CustomEntity::class;
    }

    public function getEntityCollection(): string
    {
        return CustomCollection::class;
    }

    public function getSchema(): Schema
    {
        return new Schema($this->getEntityName(), new PropertyCollection());
    }
}
