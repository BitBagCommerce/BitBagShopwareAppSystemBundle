<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\NotificationService as SdkNotificationService;
use Vin\ShopwareSdk\Service\Struct\Notification;

final class NotificationService implements NotificationServiceInterface
{
    public function __construct(private SdkNotificationService $notificationService)
    {
    }

    public function sendNotification(Notification $notification, Context $context): ApiResponse
    {
        $this->notificationService->setContext($context);

        return $this->notificationService->sendNotification($notification);
    }
}
