<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback;

final class Modal implements FeedbackInterface
{
    public function __construct(
        private string $iframeUrl,
        private bool $expand,
        private string $size = ModalSize::MEDIUM
    ) {
    }

    public function getPayload(): array
    {
        return [
            'actionType' => FeedbackType::OPEN_MODAL,
            'payload' => [
                'iframeUrl' => $this->iframeUrl,
                'expand' => $this->expand,
                'size' => $this->size,
            ],
        ];
    }
}
