<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Model\Feedback;

interface FeedbackInterface
{
    public function getPayload(): array;
}
