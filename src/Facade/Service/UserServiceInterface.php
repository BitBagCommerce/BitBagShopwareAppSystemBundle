<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Facade\Service;

use Vin\ShopwareSdk\Data\Context;
use Vin\ShopwareSdk\Data\Entity\User\UserEntity;

interface UserServiceInterface
{
    public function me(Context $context, array $headers = []): UserEntity;

    public function updateMe(Context $context, array $headers = []): void;

    public function status(Context $context, array $headers = []): void;

    public function upsertUser(
        string $userId,
        Context $context,
        array $headers = []
    ): void;

    public function deleteUser(
        string $userId,
        Context $context,
        array $headers = []
    ): void;

    public function upsertRole(
        string $roleId,
        Context $context,
        array $headers = []
    ): void;

    public function deleteUserRole(
        string $userId,
        string $roleId,
        Context $context,
        array $headers = []
    ): void;

    public function deleteRole(
        string $roleId,
        Context $context,
        array $headers = []
    ): void;
}
