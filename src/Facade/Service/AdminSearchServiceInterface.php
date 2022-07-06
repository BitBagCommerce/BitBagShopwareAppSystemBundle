<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;

interface AdminSearchServiceInterface
{
    public function search(KeyValuePairs $criteriaCollection, Context $context): KeyValuePairs;
}
