<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Resolver\Webhook;

use BitBag\ShopwareAppSystemBundle\Model\Webhook\Event;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\Webhook;
use BitBag\ShopwareAppSystemBundle\Resolver\Webhook\WebhookResolver;
use BitBag\ShopwareAppSystemBundle\Resolver\Webhook\WebhookResolverInterface;
use BitBag\ShopwareAppSystemBundle\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;

final class WebhookResolverTest extends TestCase
{
    private string $payload;

    private SerializerInterface $serializer;

    private WebhookResolverInterface $webhookResolver;

    protected function setUp(): void
    {
        $this->payload = $this->createPayload();
        $this->serializer = new Serializer();
        $this->webhookResolver = new WebhookResolver($this->serializer);
    }

    public function testResolve(): void
    {
        $webhook = $this->webhookResolver->resolve($this->payload);

        self::assertInstanceOf(Webhook::class, $webhook);
        self::assertInstanceOf(Event::class, $webhook->getEvent());

        self::assertEquals(123123123, $webhook->getTimestamp());

        $source = $webhook->getSource();

        self::assertEquals('http://localhost:8000', $source->getUrl());
        self::assertEquals('0.0.1', $source->getAppVersion());
        self::assertEquals('dgrH7nLU6tlE', $source->getShopId());

        $data = $webhook->getEvent();
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
