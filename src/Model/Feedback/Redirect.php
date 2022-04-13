<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback;

final class Redirect implements FeedbackInterface
{
    public function __construct(private string $redirectUrl)
    {
    }

    public function getPayload(): array
    {
        return [
            'actionType' => FeedbackType::RELOAD,
            'redirectUrl' => $this->redirectUrl,
        ];
    }
}
