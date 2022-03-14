<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Repository;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;

/**
 * @method ShopInterface|null find($id, $lockMode = null, $lockVersion = null)
 * @method ShopInterface|null findOneBy(array $criteria, array $orderBy = null)
 * @method ShopInterface[]    findAll()
 * @method ShopInterface[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
interface ShopRepositoryInterface
{
    public function findSecretByShopId(string $shopId): ?string;

    public function getOneByShopId(string $shopId): ShopInterface;
}
