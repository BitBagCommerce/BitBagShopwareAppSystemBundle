<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback;

final class Reload implements FeedbackInterface
{
    public function getPayload(): array
    {
        return [
            'actionType' => FeedbackType::RELOAD,
            'payload' => [],
        ];
    }
}
