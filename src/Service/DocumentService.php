<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Service;

use Psr\Http\Message\ResponseInterface;
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

    private const DOWNLOAD_DOCUMENT_ENDPOINT = '/api_action/document/%s/%s?download=%s';

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
            \sprintf(self::CREATE_DOCUMENT_ENDPOINT, $orderId, $documentTypeName, $fileType),
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
            \sprintf(self::UPLOAD_DOCUMENT_ENDPOINT, $documentId, $extension, $fileName),
            $body,
            $headers
        );
    }

    public function downloadDocument(
        string $documentId,
        string $deepLinkCode,
        Context $context,
        bool $download = false,
        array $headers = ['Accept' => 'application/pdf'],
        ): string {
        $this->setContext($context);

        $response = $this->doRequest(
            'get',
            \sprintf(self::DOWNLOAD_DOCUMENT_ENDPOINT, $documentId, $deepLinkCode, $download ? 'true' : 'false'),
            $headers
        );

        return $response->getBody()->getContents();
    }

    private function _execute(
        string $method,
        string $path,
        array|string|null $data = null,
        array $headers = []
    ): ApiResponse {
        $response = $this->doRequest($method, $path, $headers, $data);
        $contents = self::handleResponse($response->getBody()->getContents(), $response->getHeaders());

        return new ApiResponse($contents, $response->getHeaders(), $response->getStatusCode());
    }

    private function doRequest(
        string $method,
        string $path,
        array $headers = [],
        array|string|null $data = null
    ): ResponseInterface {
        if (!in_array($method, ['get', 'post', 'put', 'patch', 'delete'])) {
            throw new \InvalidArgumentException('Method ' . $method . ' is not supported');
        }

        return $this->httpClient->$method($this->getFullUrl($path), [
            'body' => \is_array($data) ? json_encode($data) : $data,
            'headers' => $this->getBasicHeaders($headers),
        ]);
    }
}
