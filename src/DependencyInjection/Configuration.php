<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/** @psalm-suppress  PossiblyNullReference, PossiblyUndefinedMethod */
final class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('bitbag_shopware_app_system');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('app_name')->end()
                ->scalarNode('app_secret')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
