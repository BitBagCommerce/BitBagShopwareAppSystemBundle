<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Model\Notification;

use BitBag\ShopwareAppSystemBundle\Model\Feedback\FeedbackType;
use BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification\Notification;
use BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification\NotificationType;
use PHPUnit\Framework\TestCase;

final class NotificationTest extends TestCase
{
    public function testNotification(): void
    {
        $notification = new Notification(NotificationType::WARNING, 'Action performed with warnings');

        self::assertEquals([
            'actionType' => FeedbackType::NOTIFICATION,
            'payload' => [
                'status' => NotificationType::WARNING,
                'message' => 'Action performed with warnings',
            ],
        ], $notification->getPayload());
    }
}
