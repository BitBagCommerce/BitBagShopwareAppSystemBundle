<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Response;

use BitBag\ShopwareAppSystemBundle\Model\Feedback\Notification\Error;
use BitBag\ShopwareAppSystemBundle\Response\FeedbackResponse;
use function PHPUnit\Framework\assertEquals;
use PHPUnit\Framework\TestCase;

final class FeedbackResponseTest extends TestCase
{
    public function testResponse(): void
    {
        $errorFeedback = new Error('Could not perform action');
        $response = new FeedbackResponse($errorFeedback);

        $content = $response->getContent();
        $expectedJson = '{"actionType":"notification","payload":{"status":"error","message":"Could not perform action"}}';

        self::assertEquals($expectedJson, $content);
    }
}
