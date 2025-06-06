<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\TrashService;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:trash_content'
)]
class TrashContentCommand extends Command
{
    private LocationService $locationService;

    private UserService $userService;

    private TrashService $trashService;

    private PermissionResolver $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, TrashService $trashService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->trashService = $trashService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to trash'),
            new InputArgument('newParentId', InputArgument::OPTIONAL, 'New Location to restore under'),
        ])
            ->addOption('restore', 'r', InputOption::VALUE_NONE, 'Do you want to restore the content item?');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = (int) $input->getArgument('locationId');
        if ($input->getArgument('newParentId')) {
            $newParentId = (int) $input->getArgument('newParentId');
        }

        $location = $this->locationService->loadLocation($locationId);

        $this->trashService->trash($location);
        $output->writeln('Location ' . $locationId . ' moved to trash.');

        if ($input->getOption('restore')) {
            if ($input->getArgument('newParentId')) {
                $newParent = $this->locationService->loadLocation($newParentId);
            } else {
                $newParent = null;
            }
            $trashItem = $this->trashService->loadTrashItem($locationId);
            $this->trashService->recover($trashItem, $newParent);
            $output->writeln('Restored from trash.');
        }

        return self::SUCCESS;
    }
}
