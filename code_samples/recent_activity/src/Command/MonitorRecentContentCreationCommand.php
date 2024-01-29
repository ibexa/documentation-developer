<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause\LoggedAtSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MonitorRecentContentCreationCommand extends Command
{
    protected static $defaultName = 'app:monitor-content-creation';

    private ActivityLogServiceInterface $activityLogService;

    public function __construct(ActivityLogServiceInterface $activityLogService)
    {
        parent::__construct(self::$defaultName);
        $this->activityLogService = $activityLogService;
    }

    protected function configure(): void
    {
        $this->setDescription('List last 10 log entry groups with creations in the last hour')
            ->addOption('filter', 'f', InputOption::VALUE_NONE, 'If only creation log entries should be shown in log groups');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new Query([
            new Criterion\ObjectCriterion(Content::class),
            new Criterion\ActionCriterion([ActivityLogServiceInterface::ACTION_CREATE]),
            new Criterion\LoggedAtCriterion(new \DateTime('- 1 hour'), Criterion\LoggedAtCriterion::GTE),
        ], [new LoggedAtSortClause(LoggedAtSortClause::DESC)], 0, 10);

        $filterLogs = $input->getOption('filter');

        $io = new SymfonyStyle($input, $output);

        foreach ($this->activityLogService->find($query) as $activityLogGroup) {
            if ($activityLogGroup->getSource()) {
                $io->section($activityLogGroup->getSource()->getName());
            }
            if ($activityLogGroup->getDescription()) {
                $io->text($activityLogGroup->getDescription());
            }
            $table = [];
            foreach ($activityLogGroup->getActivityLogs() as $activityLog) {
                if (!$filterLogs || $activityLog->getAction() === ActivityLogServiceInterface::ACTION_CREATE) {
                    $table[] = [
                        $activityLogGroup->getLoggedAt()->format(\DateTime::ATOM),
                        $activityLog->getObjectId(),
                        $activityLog->getObjectName(),
                        $activityLog->getAction(),
                        $activityLogGroup->getUser()->login,
                    ];
                }
            }
            $io->table([
                'Logged at',
                'Obj. ID',
                'Object Name',
                'Action',
                'User',
            ], $table);
        }

        return Command::SUCCESS;
    }
}
