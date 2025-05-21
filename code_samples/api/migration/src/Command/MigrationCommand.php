<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Migration\MigrationService;
use Ibexa\Migration\Repository\Migration;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:migration'
)]
final class MigrationCommand extends Command
{
    private MigrationService $migrationService;

    public function __construct(MigrationService $migrationService)
    {
        $this->migrationService = $migrationService;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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
