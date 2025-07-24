<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Dashboard\DashboardServiceInterface;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:dashboard',
    description: 'Set a custom dashboard to user group.'
)]
class DashboardCommand
{
    private readonly Locationservice $locationService;

    private readonly ContentService $contentService;

    private readonly UserService $userService;

    private readonly PermissionResolver $permissionResolver;

    public function __construct(
        private readonly DashboardServiceInterface $dashboardService,
        Repository $repository
    ) {
        $this->locationService = $repository->getLocationService();
        $this->contentService = $repository->getContentService();
        $this->userService = $repository->getUserService();
        $this->permissionResolver = $repository->getPermissionResolver();
    }

    public function __invoke(
        #[Argument(name: 'dashboard', description: 'Location ID of the dashboard model')] string $dashboard,
        #[Argument(name: 'group', description: 'User Group Content ID(s)')] string $group,
        OutputInterface $output
    ): int {
        $dashboardModelLocationId = (int)$dashboard;
        $userGroupLocationIdList = array_map('intval', explode(',', $group));

        foreach ($userGroupLocationIdList as $userGroupLocationId) {
            try {
                $admin = $this->userService->loadUserByLogin('admin');
                $this->permissionResolver->setCurrentUserReference($admin);
                foreach ($this->userService->loadUsersOfUserGroup($this->userService->loadUserGroup($userGroupLocationId)) as $user) {
                    $this->permissionResolver->setCurrentUserReference($user);
                    $dashboardDraft = $this->dashboardService->createCustomDashboardDraft($this->locationService->loadLocation($dashboardModelLocationId));
                    $this->contentService->publishVersion($dashboardDraft->getVersionInfo());
                }
            } catch (\Throwable $throwable) {
                dump($throwable);
            }
        }

        return Command::SUCCESS;
    }
}
