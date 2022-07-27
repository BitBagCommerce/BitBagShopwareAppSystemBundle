<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\SyncPayload;

interface SyncServiceInterface
{
    public function sync(
        SyncPayload $payload,
        Context $context,
        array $headers = []
    ): ApiResponse;
}
