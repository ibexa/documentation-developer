<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:trash_content'
)]
class TrashContentCommand
{
    public function __construct(
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly TrashService $trashService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    protected function configure(): void
    {
        $this->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to trash'),
            new InputArgument('newParentId', InputArgument::OPTIONAL, 'New Location to restore under'),
        ])
            ->addOption('restore', 'r', InputOption::VALUE_NONE, 'Do you want to restore the content item?');
    }

    public function __invoke(#[\Symfony\Component\Console\Attribute\Option]
    $restore, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $locationId;
        if ($newParentId) {
            $newParentId = (int) $newParentId;
        }

        $location = $this->locationService->loadLocation($locationId);

        $this->trashService->trash($location);
        $output->writeln('Location ' . $locationId . ' moved to trash.');

        if ($restore) {
            if ($newParentId) {
                $newParent = $this->locationService->loadLocation($newParentId);
            } else {
                $newParent = null;
            }
            $trashItem = $this->trashService->loadTrashItem($locationId);
            $this->trashService->recover($trashItem, $newParent);
            $output->writeln('Restored from trash.');
        }

        return Command::SUCCESS;
    }
}
