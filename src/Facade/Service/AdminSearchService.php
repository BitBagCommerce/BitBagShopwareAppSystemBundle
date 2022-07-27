<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\AdminSearchService as SdkAdminSearchService;
use Vin\ShopwareSdk\Service\Struct\KeyValuePairs;

final class AdminSearchService implements AdminSearchServiceInterface
{
    public function __construct(private SdkAdminSearchService $adminSearchService)
    {
    }

    public function search(
        KeyValuePairs $criteriaCollection,
        Context $context,
        array $headers = []
    ): KeyValuePairs {
        $this->adminSearchService->setContext($context);

        return $this->adminSearchService->search($criteriaCollection, $headers);
    }
}
