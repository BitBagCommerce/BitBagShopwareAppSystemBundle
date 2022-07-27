<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\AdminActionService as SdkAdminActionService;
use Vin\ShopwareSdk\Service\ApiResponse;

final class AdminActionService implements AdminActionServiceInterface
{
    public function __construct(private SdkAdminActionService $adminActionService)
    {
    }

    public function execute(
        string $method,
        string $path,
        Context $context,
        array $data = [],
        array $headers = [],
        ): ApiResponse {
        $this->adminActionService->setContext($context);

        return $this->adminActionService->execute($method, $path, $data, $headers);
    }
}
