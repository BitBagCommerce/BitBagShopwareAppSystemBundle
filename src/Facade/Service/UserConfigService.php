<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;
use Vin\ShopwareSdk\Service\UserConfigService as SdkUserConfigService;

final class UserConfigService implements UserConfigServiceInterface
{
    public function __construct(private SdkUserConfigService $userConfigService)
    {
    }

    public function getConfigMe(array $keys, Context $context): KeyValuePairs
    {
        $this->userConfigService->setContext($context);

        return $this->userConfigService->getConfigMe($keys);
    }

    public function saveConfigMe(KeyValuePairs $configs, Context $context): ApiResponse
    {
        $this->userConfigService->setContext($context);

        return $this->userConfigService->saveConfigMe($configs);
    }
}
