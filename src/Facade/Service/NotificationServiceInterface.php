<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\Notification;

interface NotificationServiceInterface
{
    public function sendNotification(
        Notification $notification,
        Context $context,
        array $headers = []
    ): ApiResponse;
}
