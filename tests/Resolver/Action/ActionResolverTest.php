<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Resolver\Action;

use BitBag\ShopwareAppSystemBundle\Model\Action\Action;
use BitBag\ShopwareAppSystemBundle\Model\Action\ActionInterface;
use BitBag\ShopwareAppSystemBundle\Model\Action\DataInterface;
use BitBag\ShopwareAppSystemBundle\Model\Action\MetaInterface;
use BitBag\ShopwareAppSystemBundle\Model\Webhook\SourceInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolver;
use BitBag\ShopwareAppSystemBundle\Serializer\Serializer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

final class ActionResolverTest extends TestCase
{
    private Action $action;

    protected function setUp(): void
    {
        $serializer = new Serializer();
        $actionResolver = new ModelResolver($serializer);
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            [],
            $this->createPayload(),
        );

        $this->action = $actionResolver->resolve($request, Action::class);
    }

    public function testInstances(): void
    {
        self::assertInstanceOf(ActionInterface::class, $this->action);
        self::assertInstanceOf(SourceInterface::class, $this->action->getSource());
        self::assertInstanceOf(DataInterface::class, $this->action->getData());
        self::assertInstanceOf(MetaInterface::class, $this->action->getMeta());
    }

    public function testSource(): void
    {
        $source = $this->action->getSource();
        self::assertEquals('http://localhost:8000', $source->getUrl());
        self::assertEquals('1.0.0', $source->getAppVersion());
        self::assertEquals('F0nWInXj5Xyr', $source->getShopId());
    }

    public function testData(): void
    {
        $data = $this->action->getData();

        self::assertEquals(['2132f284f71f437c9da71863d408882f'], $data->getIds());
        self::assertEquals('product', $data->getEntity());
        self::assertEquals('restockProduct', $data->getAction());
    }

    public function testMeta(): void
    {
        $meta = $this->action->getMeta();

        self::assertEquals('1592403610', $meta->getTimestamp());
        self::assertEquals('9e968471797b4f29be3e3cf09f52d8da', $meta->getReference());
        self::assertEquals('2fbb5fe2e29a4d70aa5854ce7ce3e20b', $meta->getLanguage());
    }

    private function createPayload(): string
    {
        return <<<JSON
            {
              "source":{
                "url":"http:\/\/localhost:8000",
                "appVersion":"1.0.0",
                "shopId":"F0nWInXj5Xyr"
              },
              "data":{
                "ids":[
                  "2132f284f71f437c9da71863d408882f"
                ],
                "entity":"product",
                "action":"restockProduct"
              },
              "meta":{
                "timestamp":1592403610,
                "reference":"9e968471797b4f29be3e3cf09f52d8da",
                "language":"2fbb5fe2e29a4d70aa5854ce7ce3e20b"
              }
            }
        JSON;
    }
}
