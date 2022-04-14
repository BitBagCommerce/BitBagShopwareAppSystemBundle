<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Security;

use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
use BitBag\ShopwareAppSystemBundle\Resolver\Webhook\WebhookResolverInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class WebhookRequestAuthenticator extends AbstractAuthenticator
{
    protected ShopRepositoryInterface $shopRepository;

    private WebhookResolverInterface $webhookResolver;

    public function __construct(
        ShopRepositoryInterface $shopRepository,
        WebhookResolverInterface $webhookResolver
    ) {
        $this->shopRepository = $shopRepository;
        $this->webhookResolver = $webhookResolver;
    }

    public function supports(Request $request): ?bool
    {
        return 'POST' === $request->getMethod();
    }

    public function authenticate(Request $request): Passport
    {
        $requestContent = $request->getContent();

        if (empty($requestContent)) {
            throw new UnauthorizedHttpException('');
        }

        $webhook = $this->webhookResolver->resolve($request->getContent());
        $shopId = $webhook->getSource()->getShopId();
        $shopSecret = $this->shopRepository->findSecretByShopId($shopId);

        if (null === $shopSecret) {
            throw new UnauthorizedHttpException('shopSecret');
        }

        $hmac = \hash_hmac('sha256', $request->getContent(), $shopSecret);
        $signature = $this->getShopSignature($request) ?? '';

        if (!\hash_equals($hmac, $signature)) {
            throw new UnauthorizedHttpException('shopware-shop-signature');
        }

        return new SelfValidatingPassport(new UserBadge($shopId));
    }

    public function onAuthenticationSuccess(
        Request $request,
        TokenInterface $token,
        string $firewallName
    ): ?Response {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }

    private function getShopSignature(Request $request): ?string
    {
        return $request->headers->get('shopware-shop-signature');
    }
}
