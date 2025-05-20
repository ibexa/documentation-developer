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
    name: 'doc:move_content'
)]
class MoveContentCommand extends Command
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
            ->setDescription('Moves the selected Location with its subtree.')
            ->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to copy'),
            new InputArgument('targetLocationId', InputArgument::REQUIRED, 'Target to copy or move to'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $input->getArgument('locationId');
        $targetLocationId = (int) $input->getArgument('targetLocationId');

        $sourceLocation = $this->locationService->loadLocation($locationId);
        $targetLocation = $this->locationService->loadLocation($targetLocationId);
        $this->locationService->moveSubtree($sourceLocation, $targetLocation);
        $output->writeln('Location ' . $locationId . ' moved to ' . $targetLocationId . ' with its subtree.');

        return self::SUCCESS;
    }
}
