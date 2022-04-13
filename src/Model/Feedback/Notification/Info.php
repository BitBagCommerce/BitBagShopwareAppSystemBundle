<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification;

final class Info extends Notification
{
    public function __construct(string $message)
    {
        parent::__construct(NotificationType::INFO, $message);
    }
}
