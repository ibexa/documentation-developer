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
    name: 'doc:delete_content'
)]
class DeleteContentCommand
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'Location to delete')] int $locationId,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->deleteLocation($location);

        $output->writeln('Location ' . $locationId . ' deleted.');

        return Command::SUCCESS;
    }
}
