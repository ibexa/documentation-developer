<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Platform\Migration\Repository\Migration;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class MigrationCommand extends Command
{
    protected static $defaultName = 'doc:migration';

    private $migrationService;

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $string_with_migration_content = '';
        $this->migrationService->add(
            new Migration(
                'new_migration.yaml',
                $string_with_migration_content
            )
        );

        foreach ($this->migrationService->listMigrations() as $migration) {
            $output->writeln($migration->getName());
        }

        $migration_name = $this->migrationService->listMigrations()[0]->getName();
        $my_migration = $this->migrationService->findOneByName($migration_name);

        $this->migrationService->executeOne($my_migration);
        $this->migrationService->executeAll('admin');

        return self::SUCCESS;
    }
}
