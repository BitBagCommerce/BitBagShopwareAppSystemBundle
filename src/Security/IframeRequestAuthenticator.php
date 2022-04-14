<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Security;

use BitBag\ShopwareAppSystemBundle\Repository\ShopRepositoryInterface;
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

final class IframeRequestAuthenticator extends AbstractAuthenticator
{
    public function __construct(private ShopRepositoryInterface $shopRepository)
    {}

    public function supports(Request $request): ?bool
    {
        return 'GET' === $request->getMethod();
    }

    public function authenticate(Request $request): Passport
    {
        /** @var string $shopId */
        $shopId = $request->request->get('shop-id', '');
        $shopSecret = $this->shopRepository->findSecretByShopId($shopId);

        if (null === $shopSecret) {
            throw new UnauthorizedHttpException('');
        }

        $query = $request->query->all();

        /** @var string|null $shopSignature */
        $shopSignature = $query['shopware-shop-signature'];

        if (null === $shopSignature) {
            throw new UnauthorizedHttpException('shopware-shop-signature');
        }

        unset($query['shopware-shop-signature']);
        $queryString = \http_build_query($query);

        $hmac = \hash_hmac('sha256', $queryString, $shopSecret);

        if (!\hash_equals($hmac, $shopSignature)) {
            throw new UnauthorizedHttpException('');
        }

        return new SelfValidatingPassport(new UserBadge($shopId));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return null;
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(null, Response::HTTP_UNAUTHORIZED);
    }
}
