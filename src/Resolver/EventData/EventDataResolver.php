<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Resolver\EventData;

use BitBag\ShopwareAppSystemBundle\Event\EventData;

final class EventDataResolver implements EventDataResolverInterface
{
    public function resolve(array $data): array
    {
        /** @var string $event */
        $event = $data['event'];
        $payload = $data['payload'] ?? [];
        $eventData = [];

        foreach ($payload as $item) {
            /** @var string|null $entity */
            $entity = $item['entity'] ?? null;

            /** @var string|null $operation */
            $operation = $item['operation'] ?? null;

            /** @var string|null $primaryKey */
            $primaryKey = $item['primaryKey'] ?? null;

            /** @var string[] $updatedFields */
            $updatedFields = $item['updatedFields'] ?? [];

            $eventData[] = new EventData(
                $entity,
                $operation,
                $primaryKey,
                $updatedFields,
                $event,
                $item
            );
        }

        return $eventData;
    }
}
