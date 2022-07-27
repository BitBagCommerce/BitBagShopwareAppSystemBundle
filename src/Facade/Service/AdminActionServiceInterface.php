<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;

interface AdminActionServiceInterface
{
    public function execute(
        string $method,
        string $path,
        Context $context,
        array $data = [],
        array $headers = []
    ): ApiResponse;
}
