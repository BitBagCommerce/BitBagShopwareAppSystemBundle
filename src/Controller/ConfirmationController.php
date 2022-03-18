<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Controller;

use BitBag\ShopwareAppSystemBundle\Authenticator\AuthenticatorInterface;
use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use BitBag\ShopwareAppSystemBundle\Exception\ShopNotFoundException;
use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ConfirmationController
{
    private AuthenticatorInterface $authenticator;

    private ShopRepositoryInterface $shopRepository;

    private EntityManagerInterface $entityManager;

    private ValidatorInterface $validator;

    public function __construct(
        AuthenticatorInterface $authenticator,
        ShopRepositoryInterface $shopRepository,
        EntityManagerInterface $entityManager,
        ValidatorInterface $validator
    ) {
        $this->authenticator = $authenticator;
        $this->shopRepository = $shopRepository;
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function __invoke(Request $request): Response
    {
        /** @var array $requestContent */
        $requestContent = json_decode($request->getContent(), true);

        $violations = $this->validator->validate($requestContent, $this->getConfirmationRequestConstraint());

        if (0 !== $violations->count()) {
            throw new BadRequestHttpException('Invalid confirmation request');
        }

        /** @var string $shopId */
        $shopId = $requestContent['shopId'];
        $shop = $this->shopRepository->find($shopId);

        if (null === $shop) {
            throw new ShopNotFoundException($shopId);
        }

        $shopSecret = $shop->getShopSecret();
        if (!$this->authenticator->authenticatePostRequest($request, $shopSecret)) {
            throw new UnauthorizedHttpException('');
        }

        $this->updateShop(
            $shop,
            $requestContent['apiKey'],
            $requestContent['secretKey']
        );

        return new Response();
    }

    private function getConfirmationRequestConstraint(): Collection
    {
        return new Collection([
            'apiKey' => new NotBlank(),
            'secretKey' => new NotBlank(),
            'timestamp' => new NotBlank(),
            'shopUrl' => new NotBlank(),
            'shopId' => new NotBlank(),
        ]);
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
}
