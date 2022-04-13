<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification;

use BitBag\ShopwareAppSystemBundle\Model\Feedback\FeedbackInterface;
use BitBag\ShopwareAppSystemBundle\Model\Feedback\FeedbackType;

class Notification implements FeedbackInterface
{
    public function __construct(private string $status, private string $message)
    {
    }

    public function getPayload(): array
    {
        return [
            'actionType' => FeedbackType::NOTIFICATION,
            'payload' => [
                'status' => $this->status,
                'message' => $this->message,
            ],
        ];
    }
}
