<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
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

    public function __invoke(
        #[Argument(description: 'Location to copy')] int $locationId,
        #[Argument(description: 'Target to copy or move to')] int $targetLocationId,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $sourceLocation = $this->locationService->loadLocation($locationId);
        $targetLocation = $this->locationService->loadLocation($targetLocationId);
        $this->locationService->moveSubtree($sourceLocation, $targetLocation);
        $output->writeln('Location ' . $locationId . ' moved to ' . $targetLocationId . ' with its subtree.');

        return Command::SUCCESS;
    }
}
