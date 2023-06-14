<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\TrashService;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class TrashContentCommand extends Command
{
    private $locationService;

    private $userService;

    private $trashService;

    private $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, TrashService $trashService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->trashService = $trashService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:trash_content');
    }

    protected function configure()
    {
        $this->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to trash'),
            new InputArgument('newParentId', InputArgument::OPTIONAL, 'New Location to restore under'),
        ])
            ->addOption('restore', 'r', InputOption::VALUE_NONE, 'Do you want to restore the Content item?');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = $input->getArgument('locationId');
        if ($input->getArgument('newParentId')) {
            $newParentId = $input->getArgument('newParentId');
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
