<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause\LoggedAtSortClause;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $this->setDescription('List last 10 Content item creations in the last hour');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new Query([
            new Criterion\ObjectCriterion(Content::class),
            new Criterion\ActionCriterion(['create']),
            new Criterion\LoggedAtCriterion(new \DateTime('- 1 hour'), Criterion\LoggedAtCriterion::GTE),
        ], [new LoggedAtSortClause(LoggedAtSortClause::DESC)], 0, 10);

        foreach ($this->activityLogService->find($query) as $activityLog) {
            $output->writeln("[{$activityLog->getLoggedAt()->format(\DateTime::ATOM)}] Content #{$activityLog->getObjectId()} <info>{$activityLog->getObjectName()}</info> created by <comment>{$activityLog->getUser()->login}</comment>");
        }

        return Command::SUCCESS;
    }
}
