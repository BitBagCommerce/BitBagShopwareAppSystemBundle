<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Entity\User\UserEntity;
use Vin\ShopwareSdk\Service\UserService as SdkUserService;

final class UserService implements UserServiceInterface
{
    public function __construct(private SdkUserService $userService)
    {
    }

    public function me(Context $context, array $headers = []): UserEntity
    {
        $this->userService->setContext($context);

        return $this->userService->me($headers);
    }

    public function updateMe(Context $context, array $headers = []): void
    {
        $this->userService->setContext($context);

        $this->userService->updateMe($headers);
    }

    public function status(Context $context, array $headers = []): void
    {
        $this->userService->setContext($context);

        $this->userService->status($headers);
    }

    public function upsertUser(
        string $userId,
        Context $context,
        array $headers = []
    ): void
    {
        $this->userService->setContext($context);

        $this->userService->upsertUser($userId, $headers);
    }

    public function deleteUser(
        string $userId,
        Context $context,
        array $headers = []
    ): void
    {
        $this->userService->setContext($context);

        $this->userService->deleteUser($userId, $headers);
    }

    public function upsertRole(
        string $roleId,
        Context $context,
        array $headers = []
    ): void
    {
        $this->userService->setContext($context);

        $this->userService->upsertRole($headers, $roleId);
    }

    public function deleteUserRole(
        string $userId,
        string $roleId,
        Context $context,
        array $headers = []
    ): void {
        $this->userService->setContext($context);

        $this->userService->deleteUserRole($userId, $roleId, $headers);
    }

    public function deleteRole(
        string $roleId,
        Context $context,
        array $headers = []
    ): void
    {
        $this->userService->setContext($context);

        $this->userService->deleteRole($roleId, $headers);
    }
}
