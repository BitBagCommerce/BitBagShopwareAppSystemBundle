<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\DependencyInjection\Compiler;

use BitBag\ShopwareAppSystemBundle\Exception\MissingEntityDefinitionTagValue;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Vin\ShopwareSdk\Repository\EntityRepository;
use Vin\ShopwareSdk\Repository\RepositoryInterface;

final class CustomEntityRepositoryPass implements CompilerPassInterface
{
    private const ENTITY_DEFINITION_TAG = 'shopware.entity_definition.custom';

    private const ENTITY_REPOSITORY_SLUG = 'shopware.repository.';

    public function process(ContainerBuilder $container): void
    {
        $taggedServiceIds = $container->findTaggedServiceIds(self::ENTITY_DEFINITION_TAG);

        foreach ($taggedServiceIds as $id => $tags) {
            $tagValue = $tags[0]['value'] ?? throw new MissingEntityDefinitionTagValue(\sprintf(
                'Service %s has no valid value for tag %',
                $id,
                self::ENTITY_DEFINITION_TAG
            ));

            $entityName = 'custom_entity_' . $tagValue;

            $repositoryDefinition = new Definition(EntityRepository::class, [
                $entityName,
                new Reference($id),
                \sprintf('/%s', str_replace('_', '-', $entityName)),
            ]);

            $repositoryDefinitionName = self::ENTITY_REPOSITORY_SLUG . $entityName;

            $container
                ->setDefinition($repositoryDefinitionName, $repositoryDefinition)
                ->setPublic(true);

            $container->registerAliasForArgument(
                $repositoryDefinitionName,
                RepositoryInterface::class,
                $entityName . '.repository'
            );
        }
    }
}
