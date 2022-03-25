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
        $queryBuilder = $this->createQueryBuilder('shop');
        $queryBuilder
            ->select('s.shopSecret')
            ->from('BitBagShopwareAppSystemBundle:Shop', 's')
            ->where('shop.shopId = :shopId')
            ->setParameter('shopId', $shopId);

        /** @var string|null $result */
        $result = $queryBuilder->getQuery()->getSingleScalarResult();

        return $result;
    }

    public function getOneByShopId(string $shopId): ShopInterface
    {
        $shop = $this->find($shopId);

        if (null === $shop) {
            throw new ShopNotFoundException($shopId);
        }

        return $shop;
    }
}
