<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Controller;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use BitBag\ShopwareAppSystemBundle\Exception\ShopNotFoundException;
use BitBag\ShopwareAppSystemBundle\Model\Request\ConfirmationRequest;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Model\ModelResolverInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

final class ConfirmationController
{
    public function __construct(
        private ShopRepositoryInterface $shopRepository,
        private EntityManagerInterface $entityManager,
        private ModelResolverInterface $modelResolver
    ) {
    }

    public function __invoke(Request $request): Response
    {
        /** @var ConfirmationRequest $confirmationRequest */
        $confirmationRequest = $this->modelResolver->resolve($request, ConfirmationRequest::class);

        $shopId = $confirmationRequest->getShopId();
        $shop = $this->shopRepository->find($shopId);

        if (null === $shop) {
            throw new ShopNotFoundException($shopId);
        }

        $shopSecret = $shop->getShopSecret();

        if (!$this->authenticatePostRequest($request, $shopSecret)) {
            throw new UnauthorizedHttpException('');
        }

        $this->updateShop(
            $shop,
            $confirmationRequest->getApiKey(),
            $confirmationRequest->getSecretKey()
        );

        return new Response();
    }

    private function updateShop(
        ShopInterface $shop,
        string $apiKey,
        string $secretKey
    ): void {
        $shop->setApiKey($apiKey);
        $shop->setSecretKey($secretKey);

        $this->entityManager->persist($shop);
        $this->entityManager->flush();
    }

    private function authenticatePostRequest(Request $request, string $shopSecret): bool
    {
        if (!array_key_exists('shopware-shop-signature', $request->headers->all())) {
            return false;
        }

        $signature = $request->headers->get('shopware-shop-signature', '');

        $hmac = \hash_hmac('sha256', $request->getContent(), $shopSecret);

        return \hash_equals($hmac, $signature);
    }
}
