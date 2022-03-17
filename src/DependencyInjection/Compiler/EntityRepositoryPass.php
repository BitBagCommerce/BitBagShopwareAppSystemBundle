<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\DependencyInjection\Compiler;

use BitBag\ShopwareAppSystemBundle\Exception\InvalidEntityMappingException;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Vin\ShopwareSdk\Repository\EntityRepository;
use Vin\ShopwareSdk\Repository\RepositoryInterface;

final class EntityRepositoryPass implements CompilerPassInterface
{
    private const ENTITY_MAPPING = __DIR__ . '/../../Resources/config/mapping/entity-mapping.json';

    private const ENTITY_DEFINITION_SLUG = 'shopware.entity_definition.';

    private const ENTITY_REPOSITORY_SLUG = 'shopware.repository.';

    public function process(ContainerBuilder $container): void
    {
        $entityClasses = $this->getMapping();

        foreach ($entityClasses as $entityName => $definitionClass) {
            $entityDefinitionName = self::ENTITY_DEFINITION_SLUG . $entityName;
            $repositoryDefinitionName = self::ENTITY_REPOSITORY_SLUG . $entityName;

            $entityDefinitionDefinition = new Definition($definitionClass);

            $container
                ->setDefinition($entityDefinitionName, $entityDefinitionDefinition)
                ->setPublic(true);

            $repositoryDefinition = new Definition(EntityRepository::class, [
                $entityName,
                new Reference($entityDefinitionName),
                \sprintf('/%s', str_replace('_', '-', $entityName)),
            ]);

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

    private function getMapping(): array
    {
        $contents = \file_get_contents(self::ENTITY_MAPPING);

        if ($contents === false) {
            throw new InvalidEntityMappingException(\sprintf(
                'File at %s could not be read.',
                self::ENTITY_MAPPING
            ));
        }

        try {
            return \json_decode($contents, true);
        } catch (\JsonException $e) {
            throw new InvalidEntityMappingException(\sprintf(
                'Invalid entity mapping found at %s',
                self::ENTITY_MAPPING
            ));
        }
    }
}
