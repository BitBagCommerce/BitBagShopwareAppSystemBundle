<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

final class BitBagShopwareAppSystemExtension extends Extension
{
    private const TAG_NAME = 'bitbag.shopware_app_system.auth_guarded';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->appAppCredentials($container, $config);
    }

    public function getAlias(): string
    {
        return 'bitbag_shopware_app_system';
    }

    private function appAppCredentials(ContainerBuilder $container, array $config): void
    {
        $definitions = $this->getTaggedServices($container, self::TAG_NAME);

        foreach ($definitions as $definition) {
            $definition->setArgument('$appName', $config['app_name']);
            $definition->setArgument('$appSecret', $config['app_secret']);
        }
    }

    /**
     * @return Definition[]
     */
    private function getTaggedServices(ContainerBuilder $container, string $tagName): array
    {
        $ids = \array_keys($container->findTaggedServiceIds($tagName));

        return \array_map(static fn (string $id) => $container->getDefinition($id), $ids);
    }
}
