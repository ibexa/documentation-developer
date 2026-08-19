# DashboardService's PHP API

Use DashboardService to manage dashboards.

Editions: Experience

You can use `DashboardService`'s PHP API to manage custom dashboards. To obtain this service, inject the `Ibexa\Contracts\Dashboard\DashboardServiceInterface`.

The service exposes two functions:

- `createCustomDashboardDraft(?Location $location = null): Content` - returns a new content item in draft state of `dashboard` content type. If no location is given, it creates a copy of the dashboard of the user currently logged in. If a location is given, it creates a copy with the given location. The default name of the customized dashboard is set as `My dashboard`. This new Content draft is located in the current user custom dashboard container.
- `createDashboard(DashboardCreateStruct $dashboardCreateStruct): Content` - publishes the given dashboard creation structure (`Ibexa\Contracts\Dashboard\Values\DashboardCreateStruct`) under `dashboard.predefined_container_remote_id`.

## Customize dashboard using DashboardService

The following example is a command deploying a custom dashboard to users of content groups. Using the `admin` account, it loads the group members, logs each one in, creates a custom dashboard by copying a default one, and then publishes the draft version of customized dashboard. First argument is the `Content ID` of the dashboard to copy. Following arguments are the Content IDs of the user groups.

```php
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

#[AsCommand(
    name: 'doc:dashboard',
    description: 'Set a custom dashboard to user group.'
)]
class DashboardCommand extends Command
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
        $userGroupLocationIdList = array_map(intval(...), $input->getArgument('group'));

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
```

The following line runs the command with `74` as the model dashboard's Content ID, `13` the user group's Content ID, and on the SiteAccess `admin` to have the right `user_content_type_identifier` config:

```bash
php bin/console doc:dashboard 74 13 --siteaccess=admin
```
