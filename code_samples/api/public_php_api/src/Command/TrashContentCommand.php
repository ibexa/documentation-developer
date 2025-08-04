<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
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

    public function __invoke(
        OutputInterface $output,
        #[Argument(description: 'Location to trash')] int $locationId,
        #[Argument(description: 'New Location to restore under')] ?int $newParentId,
        #[Option(shortcut: 'r', description: 'Do you want to restore the content item?')] bool $restore = false
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

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
