<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle;

use BitBag\ShopwareAppSystemBundle\DependencyInjection\BitBagShopwareAppSystemExtension;
use BitBag\ShopwareAppSystemBundle\DependencyInjection\Compiler\CustomEntityRepositoryPass;
use BitBag\ShopwareAppSystemBundle\DependencyInjection\Compiler\EntityRepositoryPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class BitBagShopwareAppSystemBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new EntityRepositoryPass());
        $container->addCompilerPass(new CustomEntityRepositoryPass());
    }

    public function getContainerExtension(): ExtensionInterface
    {
        if (null === $this->extension) {
            $this->extension = new BitBagShopwareAppSystemExtension();
        }

        return $this->extension;
    }
}
