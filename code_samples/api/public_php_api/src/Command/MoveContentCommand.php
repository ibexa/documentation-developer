<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MoveContentCommand extends Command
{
    private $locationService;

    private $userService;

    private $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:move_content');
    }

    protected function configure()
    {
        $this
            ->setDescription('Moves the selected Location with its subtree.')
            ->setDefinition([
            new InputArgument('locationId', InputArgument::REQUIRED, 'Location to copy'),
            new InputArgument('targetLocationId', InputArgument::REQUIRED, 'Target to copy or move to'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = $input->getArgument('locationId');
        $targetLocationId = $input->getArgument('targetLocationId');

        $sourceLocation = $this->locationService->loadLocation($locationId);
        $targetLocation = $this->locationService->loadLocation($targetLocationId);
        $this->locationService->moveSubtree($sourceLocation, $targetLocation);
        $output->writeln('Location ' . $locationId . ' moved to ' . $targetLocationId . ' with its subtree.');

        return self::SUCCESS;
    }
}
