<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\StateMachineService as SdkStateMachineService;

final class StateMachineService implements StateMachineServiceInterface
{
    public function __construct(private SdkStateMachineService $stateMachineService)
    {
    }

    public function getState(
        string $entity,
        string $entityId,
        Context $context,
        array $headers = []
    ): ApiResponse {
        $this->stateMachineService->setContext($context);

        return $this->stateMachineService->getState($entity, $entityId, [], $headers);
    }

    public function transitionState(
        string $entity,
        string $entityId,
        string $actionName,
        Context $context,
        array $headers = []
    ): void {
        $this->stateMachineService->setContext($context);

        $this->stateMachineService->transitionState($entity, $entityId, $actionName, [], $headers);
    }
}
