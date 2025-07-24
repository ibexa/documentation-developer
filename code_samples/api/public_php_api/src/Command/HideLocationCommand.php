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
    name: 'doc:hide',
    description: 'Hides and reveals again selected Location.'
)]
class HideLocationCommand
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'Location ID')] int $location_id,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = $location_id;

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->hideLocation($location);
        $output->writeln('Location hidden: ' . $locationId);

        $this->locationService->unhideLocation($location);
        $output->writeln('Location revealed: ' . $locationId);

        return Command::SUCCESS;
    }
}
