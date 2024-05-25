<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\ActivityLog\ActivityLogServiceInterface;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Criterion;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\Query;
use Ibexa\Contracts\ActivityLog\Values\ActivityLog\SortClause\LoggedAtSortClause;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class MonitorRecentContentCreationCommand extends Command
{
    protected static $defaultName = 'app:monitor-content-creation';

    protected static $defaultDescription = 'List last 10 log entry groups with creations in the last hour';

    private ActivityLogServiceInterface $activityLogService;

    private PermissionResolver $permissionResolver;

    private UserService $userService;

    public function __construct(ActivityLogServiceInterface $activityLogService, PermissionResolver $permissionResolver, UserService $userService)
    {
        $this->permissionResolver = $permissionResolver;
        $this->userService = $userService;
        $this->activityLogService = $activityLogService;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new Query([
            new Criterion\ObjectCriterion(Content::class),
            new Criterion\ActionCriterion([ActivityLogServiceInterface::ACTION_CREATE]),
            new Criterion\LoggedAtCriterion(new \DateTime('- 1 hour'), Criterion\LoggedAtCriterion::GTE),
        ], [new LoggedAtSortClause(LoggedAtSortClause::DESC)], 0, 10);

        $io = new SymfonyStyle($input, $output);

        $this->permissionResolver->setCurrentUserReference($this->userService->loadUserByLogin('admin'));

        foreach ($this->activityLogService->findGroups($query) as $activityLogGroup) {
            if ($activityLogGroup->getSource()) {
                $io->section($activityLogGroup->getSource()->getName());
            }
            if ($activityLogGroup->getDescription()) {
                $io->text($activityLogGroup->getDescription());
            }
            $table = [];
            foreach ($activityLogGroup->getActivityLogs() as $activityLog) {
                /** @var \Ibexa\Contracts\Core\Repository\Values\Content\Content $content */
                $content = $activityLog->getRelatedObject();
                $name = $content && $content->getName() && $content->getName() !== $activityLog->getObjectName() ? "“{$content->getName()}” (formerly “{$activityLog->getObjectName()}”)" : "“{$activityLog->getObjectName()}”";
                $table[] = [
                    $activityLogGroup->getLoggedAt()->format(\DateTime::ATOM),
                    $activityLog->getObjectId(),
                    $name,
                    $activityLog->getAction(),
                    $activityLogGroup->getUser() != null ? $activityLogGroup->getUser()->login : 'No user',
                ];
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
