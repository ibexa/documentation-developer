<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HideLocationCommand extends Command
{
    private $locationService;

    private $userService;

    private $permissionResolver;

    public function __construct(LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:hide');
    }

    protected function configure()
    {
        $this
            ->setDescription('Hides and reveals again selected Location.')
            ->setDefinition([
                new InputArgument('location_id', InputArgument::REQUIRED, 'Location ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationId = $input->getArgument('location_id');

        $location = $this->locationService->loadLocation($locationId);

        $this->locationService->hideLocation($location);
        $output->writeln('Location hidden: ' . $locationId);

        $this->locationService->unhideLocation($location);
        $output->writeln('Location revealed: ' . $locationId);

        return self::SUCCESS;
    }
}
