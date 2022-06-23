<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;

interface StateMachineServiceInterface
{
    public function getState(
        string $entity,
        string $entityId,
        Context $context
    ): ApiResponse;

    public function transitionState(
        string $entity,
        string $entityId,
        string $actionName,
        Context $context
    ): void;
}
