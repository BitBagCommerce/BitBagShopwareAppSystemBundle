<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\ApiResponse;

interface DocumentServiceInterface
{
    public function createDocument(
        string $orderId,
        string $documentTypeName,
        Context $context,
        array $headers = [],
        string $fileType = 'pdf',
        ): ApiResponse;

    public function uploadDocument(
        string $documentId,
        string $fileName,
        array|string $body,
        Context $context,
        string $extension = 'pdf'
    ): ApiResponse;

    public function downloadDocument(
        string $documentId,
        string $deepLinkCode,
        Context $context,
        bool $download = false,
        array $headers = ['Accept' => 'application/pdf'],
        ): string;
}
