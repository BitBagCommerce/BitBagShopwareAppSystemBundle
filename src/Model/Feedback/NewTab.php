<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback;

final class NewTab implements FeedbackInterface
{
    public function __construct(private string $redirectUrl)
    {
    }

    public function getPayload(): array
    {
        return [
            'actionType' => 'openNewTab',
            'payload' => [
                'redirectUrl' => $this->redirectUrl,
            ],
        ];
    }
}
