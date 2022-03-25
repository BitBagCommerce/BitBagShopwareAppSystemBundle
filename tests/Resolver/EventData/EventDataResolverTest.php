<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Tests\Resolver\EventData;

use BitBag\ShopwareAppSystemBundle\Resolver\EventData\EventDataResolver;
use BitBag\ShopwareAppSystemBundle\Resolver\EventData\EventDataResolverInterface;
use PHPUnit\Framework\TestCase;

final class EventDataResolverTest extends TestCase
{
    private EventDataResolverInterface $eventDataResolver;

    protected function setUp(): void
    {
        $this->eventDataResolver = new EventDataResolver();
    }

    /** @dataProvider provideEventData */
    public function testResolve(
        array $data,
        string $event,
        string $entity,
        string $operation,
        string $primaryKey,
        array $updatedFields
    ): void {
        $eventDataCollection = $this->eventDataResolver->resolve($data);
        $eventData = $eventDataCollection[0] ?? null;

        self::assertNotNull($eventData);
        self::assertEquals($event, $eventData->getEvent());
        self::assertEquals($entity, $eventData->getEntity());
        self::assertEquals($operation, $eventData->getOperation());
        self::assertEquals($primaryKey, $eventData->getPrimaryKey());
        self::assertEquals($updatedFields, $eventData->getUpdatedFields());
    }

    public function provideEventData(): array
    {
        return [
            [
                [
                    'event' => 'product.written',
                    'payload' => [
                        [
                            'entity' => 'product',
                            'operation' => 'delete',
                            'primaryKey' => '7b04ebe416db4ebc93de4d791325e1d9',
                            'updatedFields' => [],
                        ],
                    ],
                ], 'product.written', 'product', 'delete', '7b04ebe416db4ebc93de4d791325e1d9', [],
            ],
        ];
    }
}
