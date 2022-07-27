<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\SyncPayload;
use Vin\ShopwareSdk\Service\SyncService as SdkSyncService;

final class SyncService implements SyncServiceInterface
{
    public function __construct(private SdkSyncService $syncService)
    {
    }

    public function sync(
        SyncPayload $payload,
        Context $context,
        array $headers = []
    ): ApiResponse
    {
        $this->syncService->setContext($context);

        return $this->syncService->sync($payload, [], $headers);
    }
}
