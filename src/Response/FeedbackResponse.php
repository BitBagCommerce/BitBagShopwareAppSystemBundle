<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Response;

use BitBag\ShopwareAppSystemBundle\Model\Feedback\FeedbackInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/** @psalm-suppress PropertyNotSetInConstructor */
final class FeedbackResponse extends JsonResponse
{
    public function __construct(private FeedbackInterface $actionFeedback)
    {
        parent::__construct($actionFeedback->getPayload());
    }

    public function getActionFeedback(): FeedbackInterface
    {
        return $this->actionFeedback;
    }
}
