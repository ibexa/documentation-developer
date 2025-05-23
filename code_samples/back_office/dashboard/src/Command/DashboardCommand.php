<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\Repository;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Dashboard\DashboardServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:dashboard', description: 'Set a custom dashboard to user group.')]
class DashboardCommand extends Command
{
    private DashboardServiceInterface $dashboardService;

    private Locationservice $locationService;

    private ContentService $contentService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(
        DashboardServiceInterface $dashboardService,
        Repository $repository
    ) {
        $this->dashboardService = $dashboardService;
        $this->locationService = $repository->getLocationService();
        $this->contentService = $repository->getContentService();
        $this->userService = $repository->getUserService();
        $this->permissionResolver = $repository->getPermissionResolver();

        parent::__construct();
    }

    public function configure(): void
    {
        $this
            ->addArgument('dashboard', InputArgument::REQUIRED, 'Location ID of the dashboard model')
            ->addArgument('group', InputArgument::REQUIRED | InputArgument::IS_ARRAY, 'User Group Content ID(s)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $dashboardModelLocationId = (int)$input->getArgument('dashboard');
        $userGroupLocationIdList = array_map('intval', $input->getArgument('group'));

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

        return self::SUCCESS;
    }
}
