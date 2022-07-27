<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;

interface UserConfigServiceInterface
{
    public function getConfigMe(
        array $keys,
        Context $context,
        array $headers = []
    ): KeyValuePairs;

    public function saveConfigMe(
        KeyValuePairs $configs,
        Context $context,
        array $headers = []
    ): ApiResponse;
}
