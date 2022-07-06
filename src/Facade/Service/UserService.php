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

    public function me(Context $context): UserEntity
    {
        $this->userService->setContext($context);

        return $this->userService->me();
    }

    public function updateMe(Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->updateMe();
    }

    public function status(Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->status();
    }

    public function upsertUser(string $userId, Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->upsertUser($userId);
    }

    public function deleteUser(string $userId, Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->deleteUser($userId);
    }

    public function upsertRole(string $roleId, Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->upsertRole([], $roleId);
    }

    public function deleteUserRole(
        string $userId,
        string $roleId,
        Context $context
    ): void {
        $this->userService->setContext($context);

        $this->userService->deleteUserRole($userId, $roleId);
    }

    public function deleteRole(string $roleId, Context $context): void
    {
        $this->userService->setContext($context);

        $this->userService->deleteRole($roleId);
    }
}
