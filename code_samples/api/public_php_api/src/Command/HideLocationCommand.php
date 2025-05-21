<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:hide'
)]
class HideLocationCommand extends Command
{
    private LocationService $locationService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Hides and reveals again selected Location.')
            ->setDefinition([
                new InputArgument('location_id', InputArgument::REQUIRED, 'Location ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $input->getArgument('location_id');

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->hideLocation($location);
        $output->writeln('Location hidden: ' . $locationId);

        $this->locationService->unhideLocation($location);
        $output->writeln('Location revealed: ' . $locationId);

        return self::SUCCESS;
    }
}
