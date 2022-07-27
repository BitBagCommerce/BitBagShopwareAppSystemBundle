<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;
use Vin\ShopwareSdk\Service\Struct\KeyValuePair;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;

interface SystemConfigServiceInterface
{
    public function checkConfiguration(
        string $domain,
        Context $context,
        array $headers = []
    ): ApiResponse;

    public function getConfiguration(
        string $domain,
        Context $context,
        array $headers = []
    ): ApiResponse;

    public function getConfigurationValues(
        string $domain,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse;

    public function save(
        KeyValuePair $configuration,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse;

    public function batchSave(
        KeyValuePairs $configs,
        Context $context,
        ?string $salesChannelId = null,
        array $headers = []
    ): ApiResponse;
}
