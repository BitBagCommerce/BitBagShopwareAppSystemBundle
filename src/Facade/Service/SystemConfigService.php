<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\KeyValuePair;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;
use Vin\ShopwareSdk\Service\SystemConfigService as SdkSystemConfigService;

final class SystemConfigService implements SystemConfigServiceInterface
{
    public function __construct(private SdkSystemConfigService $systemConfigService)
    {
    }

    public function checkConfiguration(
        string $domain,
        Context $context,
        array $headers = []
    ): ApiResponse {
        $this->systemConfigService->setContext($context);

        return $this->systemConfigService->checkConfiguration($domain);
    }

    public function getConfiguration(
        string $domain,
        Context $context,
        array $headers = []
    ): ApiResponse {
        $this->systemConfigService->setContext($context);

        return $this->systemConfigService->getConfiguration($domain);
    }

    public function getConfigurationValues(
        string $domain,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse {
        $this->systemConfigService->setContext($context);

        return $this->systemConfigService->getConfigurationValues($domain, $salesChannelId, $headers);
    }

    public function save(
        KeyValuePair $configuration,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse {
        $this->systemConfigService->setContext($context);

        return $this->systemConfigService->save($configuration, $salesChannelId, [], $headers);
    }

    public function batchSave(
        KeyValuePairs $configs,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse {
        $this->systemConfigService->setContext($context);

        return $this->systemConfigService->batchSave($configs, $salesChannelId, [], $headers);
    }
}
