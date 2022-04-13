<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Response;

use BitBag\ShopwareAppSystemBundle\Model\Feedback\FeedbackInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/** @psalm-suppress PropertyNotSetInConstructor */
final class FeedbackResponse extends JsonResponse
{
    public function __construct(FeedbackInterface $actionFeedback)
    {
        parent::__construct($actionFeedback->getPayload());
    }
}
