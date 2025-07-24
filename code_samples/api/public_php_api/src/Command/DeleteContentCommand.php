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

    protected function configure(): void
    {
        $this->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to delete'),
        ]);
    }

    public function __invoke(OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $locationId;

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->deleteLocation($location);

        $output->writeln('Location ' . $locationId . ' deleted.');

        return Command::SUCCESS;
    }
}
