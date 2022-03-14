<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Repository;

use BitBag\ShopwareAppSystemBundle\Exception\ShopNotFoundException;
use BitBag\ShopwareAppSystemBundle\Entity\Shop;
use BitBag\ShopwareAppSystemBundle\Entity\ShopInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

final class ShopRepository extends ServiceEntityRepository implements ShopRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Shop::class);
    }

    public function findSecretByShopId(string $shopId): ?string
    {
        $queryBuilder = $this->createQueryBuilder('shop');
        $queryBuilder
            ->select('s.shopSecret')
            ->from('BitBagShopwareAppSystemBundle:Shop', 's')
            ->where('shop.shopId = :shopId')
            ->setParameter('shopId', $shopId);

        /* @var ?string */
        return $queryBuilder->getQuery()->getSingleScalarResult();
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
