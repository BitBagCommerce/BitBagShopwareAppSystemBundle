<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification;

final class Warning extends Notification
{
    public function __construct(string $message)
    {
        parent::__construct(NotificationType::WARNING, $message);
    }
}
