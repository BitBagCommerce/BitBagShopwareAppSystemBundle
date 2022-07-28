<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Vin\ShopwareSdk\Repository\EntityRepository;

final class CustomEntityRepositoryPass implements CompilerPassInterface
{
    private const ENTITY_DEFINITION_SLUG = 'shopware.entity_definition.';

    private const ENTITY_REPOSITORY_SLUG = 'shopware.repository.';

    public function process(ContainerBuilder $container): void
    {
        $customEntityRepositoryDefinitions = $this->getCustomEntityDefinitions($container);

        foreach ($customEntityRepositoryDefinitions as $definition) {
            $repositoryDefinition = new Definition(EntityRepository::class, [
                $definition,
                new Reference($definition),
                \sprintf('/%s', str_replace('_', '-', $definition)),
            ]);

            $container->setDefinition(
                self::ENTITY_REPOSITORY_SLUG . $definition,
                $repositoryDefinition
            );
        }
    }

    private function getCustomEntityDefinitions(ContainerBuilder $container): array
    {
        $serviceIds = $container->getServiceIds();
        $customEntityRepositoryDefinitions = \array_filter(
            $serviceIds,
            fn (string $serviceId) => \str_starts_with($serviceId, self::ENTITY_DEFINITION_SLUG . 'custom_entity_')
        );

        if ([] === $customEntityRepositoryDefinitions) {
            return [];
        }

        return $customEntityRepositoryDefinitions;
    }
}
