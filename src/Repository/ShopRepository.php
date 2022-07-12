<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Repository;

use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use BitBag\ShopwareAppSystemBundle\Exception\ShopNotFoundException;
use Doctrine\ORM\EntityRepository;

final class ShopRepository extends EntityRepository implements ShopRepositoryInterface
{
    public function findSecretByShopId(string $shopId): ?string
    {
        /** @var ShopInterface|null $shop */
        $shop = $this->find($shopId);

        if (null === $shop) {
            return null;
        }

        return $shop->getShopSecret();
    }

    public function getOneByShopId(string $shopId): ShopInterface
    {
        /** @var ShopInterface|null $shop */
        $shop = $this->find($shopId);

        if (null === $shop) {
            throw new ShopNotFoundException($shopId);
        }

        return $shop;
    }
}
