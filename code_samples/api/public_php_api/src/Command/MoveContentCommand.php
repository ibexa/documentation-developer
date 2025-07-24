<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:move_content',
    description: 'Moves the selected Location with its subtree.'
)]
class MoveContentCommand
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to copy'),
            new InputArgument('targetLocationId', InputArgument::REQUIRED, 'Target to copy or move to'),
            ]);
    }

    public function __invoke(OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $locationId;
        $targetLocationId = (int) $targetLocationId;

        $sourceLocation = $this->locationService->loadLocation($locationId);
        $targetLocation = $this->locationService->loadLocation($targetLocationId);
        $this->locationService->moveSubtree($sourceLocation, $targetLocation);
        $output->writeln('Location ' . $locationId . ' moved to ' . $targetLocationId . ' with its subtree.');

        return Command::SUCCESS;
    }
}
