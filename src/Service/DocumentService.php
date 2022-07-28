<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Service\AdminActionService;
use Vin\ShopwareSdk\Service\ApiResponse;

/**
 * @psalm-suppress DeprecatedMethod
 */
final class DocumentService extends AdminActionService implements DocumentServiceInterface
{
    private const CREATE_DOCUMENT_ENDPOINT = '/api/_action/order/%s/document/%s?%s';

    private const UPLOAD_DOCUMENT_ENDPOINT = '/api/_action/document/%s/upload?extension=%s&fileName=%s';

    public function createDocument(
        string $orderId,
        string $documentTypeName,
        Context $context,
        array $headers = [],
        string $fileType = 'pdf',
        ): ApiResponse {
        $this->setContext($context);

        return $this->_execute(
            'post',
            $this->getFullUrl(\sprintf(self::CREATE_DOCUMENT_ENDPOINT, $orderId, $documentTypeName, $fileType)),
            ['static' => true],
            $headers
        );
    }

    public function uploadDocument(
        string $documentId,
        string $fileName,
        array|string $body,
        Context $context,
        string $extension = 'pdf',
        array $headers = []
    ): ApiResponse {
        $this->setContext($context);

        return $this->_execute(
            'post',
            $this->getFullUrl(\sprintf(self::UPLOAD_DOCUMENT_ENDPOINT, $documentId, $extension, $fileName)),
            $body,
            $headers
        );
    }

    private function _execute(
        string $method,
        string $path,
        array|string $data = '',
        array $headers = []
    ): ApiResponse {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            throw new \InvalidArgumentException('Method ' . $method . ' is not supported');
        }

        $response = $this->httpClient->$method($this->getFullUrl($path), [
            'body' => \is_array($data) ? json_encode($data) : $data,
            'headers' => $this->getBasicHeaders($headers),
        ]);

        $contents = self::handleResponse($response->getBody()->getContents(), $response->getHeaders());

        return new ApiResponse($contents, $response->getHeaders(), $response->getStatusCode());
    }
}
