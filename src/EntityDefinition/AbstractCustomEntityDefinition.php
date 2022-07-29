<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\EntityDefinition;

use Vin\ShopwareSdk\Data\Entity\Custom\CustomCollection;
use Vin\ShopwareSdk\Data\Entity\Custom\CustomEntity;
use Vin\ShopwareSdk\Data\Entity\EntityDefinition;
use Vin\ShopwareSdk\Data\Schema\Flag;
use Vin\ShopwareSdk\Data\Schema\FlagCollection;
use Vin\ShopwareSdk\Data\Schema\Property;
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
        return new Schema($this->getEntityName(), new PropertyCollection([
            new Property('id', 'uuid', new FlagCollection([new Flag('read_protected', json_decode('[["Shopware\\Core\\Framework\\Api\\Context\\AdminApiSource"]]', true)), new Flag('primary_key', 1), new Flag('required', 1), ]), []),
            new Property('createdAt', 'date', new FlagCollection([new Flag('read_protected', json_decode('[["Shopware\\Core\\Framework\\Api\\Context\\AdminApiSource","Shopware\\Core\\Framework\\Api\\Context\\SalesChannelApiSource"]]', true)), new Flag('required', 1), ]), []),
            new Property('updatedAt', 'date', new FlagCollection([new Flag('read_protected', json_decode('[["Shopware\\Core\\Framework\\Api\\Context\\AdminApiSource","Shopware\\Core\\Framework\\Api\\Context\\SalesChannelApiSource"]]', true)), ]), []),
        ]));
    }
}
