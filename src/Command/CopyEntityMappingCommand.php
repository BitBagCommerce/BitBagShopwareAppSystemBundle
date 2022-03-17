<?php declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class CopyEntityMappingCommand extends Command
{
    protected static $defaultName = 'app-system:update-entity-mapping';

    private const VENDOR_ENTITY_MAPPING_FILE_PATH = __DIR__ . '/../../vendor/vin-sw/shopware-sdk/src/Resources/entity-mapping.json';

    private const ENTITY_MAPPING_FILE_PATH = __DIR__ . '/../Resources/config/mapping/entity-mapping.json';

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output = new SymfonyStyle($input, $output);

        $output->info('Updating entity-mapping.json');

        if (!\file_exists(self::VENDOR_ENTITY_MAPPING_FILE_PATH)) {
            return 0;
        }

        $contents = \file_get_contents(self::VENDOR_ENTITY_MAPPING_FILE_PATH);

        if ($contents === false) {
            $output->error('Loading ' . self::VENDOR_ENTITY_MAPPING_FILE_PATH . ' failed');

            return 1;
        }

        $contents .= \PHP_EOL;

        \file_put_contents(self::ENTITY_MAPPING_FILE_PATH, $contents);

        return 0;
    }
}
