<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DeleteContentCommand extends Command
{
    private LocationService $locationService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:delete_content');
    }

    protected function configure()
    {
        $this->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to delete'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = $input->getArgument('locationId');

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->deleteLocation($location);

        $output->writeln('Location ' . $locationId . ' deleted.');

        return self::SUCCESS;
    }
}
