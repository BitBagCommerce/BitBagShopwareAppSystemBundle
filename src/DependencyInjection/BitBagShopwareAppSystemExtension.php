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
    private const TAG_NAME = 'bitbag.shopware_app_system.app_config.aware';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));

        $loader->load('services.xml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->addAppConfiguration($container, $config);
    }

    public function getAlias(): string
    {
        return 'bitbag_shopware_app_system';
    }

    private function addAppConfiguration(ContainerBuilder $container, array $config): void
    {
        $definitions = $this->getConfigAwareServices($container);

        foreach ($definitions as $definition) {
            $definition
                ->setArgument('$appName', $config['app_name'])
                ->setArgument('$appSecret', $config['app_secret'])
                ->setArgument('$appUrlBackend', $config['app_url_backend'])
                ->setArgument('$appUrlClient', $config['app_url_client']);
        }
    }

    /**
     * @return Definition[]
     */
    private function getConfigAwareServices(ContainerBuilder $container): array
    {
        $ids = \array_keys($container->findTaggedServiceIds(self::TAG_NAME));

        return \array_map(static fn (string $id) => $container->getDefinition($id), $ids);
    }
}
