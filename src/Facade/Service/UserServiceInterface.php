<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Entity\User\UserEntity;

interface UserServiceInterface
{
    public function me(Context $context): UserEntity;

    public function updateMe(Context $context): void;

    public function status(Context $context): void;

    public function upsertUser(string $userId, Context $context): void;

    public function deleteUser(string $userId, Context $context): void;

    public function upsertRole(string $roleId, Context $context): void;

    public function deleteUserRole(
        string $userId,
        string $roleId,
        Context $context
    ): void;

    public function deleteRole(string $roleId, Context $context): void;
}
