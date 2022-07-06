<?php

declare(strict_types=1);

namespace BitBag\ShopwareAppSystemBundle\Command;

use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class PurgeShopsCommand extends Command
{
    protected static $defaultName = 'app-system:purge-shops';

    public function __construct(private EntityManagerInterface $entityManager)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Purges all shops from the shop table. Use with caution.');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $connection = $this->entityManager->getConnection();

        try {
            $connection->beginTransaction();
            $connection->executeStatement('DELETE FROM shop');
            $connection->commit();
        } catch (Exception) {
            $connection->rollBack();

            return 1;
        }

        return 0;
    }
}
