<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Resolver\Model;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Event;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolver;
use BitBag\ShopwareAppSystemBundle\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class WebhookResolverTest extends TestCase
{
    private Webhook $webhook;

    protected function setUp(): void
    {
        $serializer = new Serializer();
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            $this->createPayload(),
        );
        $modelResolver = new ModelResolver($serializer);

        $this->webhook = $modelResolver->resolve($request, Webhook::class);
    }

    public function testInstances(): void
    {
        self::assertInstanceOf(Webhook::class, $this->webhook);
        self::assertInstanceOf(Event::class, $this->webhook->getEvent());
    }

    public function testWebhook(): void
    {
        self::assertEquals(123123123, $this->webhook->getTimestamp());
    }

    public function testSource(): void
    {
        $source = $this->webhook->getSource();

        self::assertEquals('http://localhost:8000', $source->getUrl());
        self::assertEquals('0.0.1', $source->getAppVersion());
        self::assertEquals('dgrH7nLU6tlE', $source->getShopId());
    }

    public function testPayload(): void
    {
        $data = $this->webhook->getEvent();
        $payload = $data->getPayload()[0];

        self::assertEquals('product', $payload->getEntity());
        self::assertEquals('delete', $payload->getOperation());
        self::assertEquals('7b04ebe416db4ebc93de4d791325e1d9', $payload->getPrimaryKey());
        self::assertEmpty($payload->getUpdatedFields());
    }

    private function createPayload(): string
    {
        return <<<JSON
            {
              "data": {
                "payload": [
                  {
                    "entity": "product",
                    "operation": "delete",
                    "primaryKey": "7b04ebe416db4ebc93de4d791325e1d9",
                    "updatedFields": [
                    ]
                  }
                ],
                "event": "product.written"
              },
              "source": {
                "url": "http:\/\/localhost:8000",
                "appVersion": "0.0.1",
                "shopId": "dgrH7nLU6tlE"
              },
              "timestamp": 123123123
            }
        JSON;
    }
}
