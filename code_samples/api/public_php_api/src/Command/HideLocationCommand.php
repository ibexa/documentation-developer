<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;

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
