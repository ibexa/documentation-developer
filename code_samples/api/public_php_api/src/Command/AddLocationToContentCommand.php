<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddLocationToContentCommand extends Command
{
    private $contentService;

    private $locationService;

    private $userService;

    private $permissionResolver;

    public function __construct(ContentService $contentService, LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:add_location');
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a Location to Content item and hides it.')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'Content ID'),
                new InputArgument('parentLocationId', InputArgument::REQUIRED, 'Parent Location ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $parentLocationId = $input->getArgument('parentLocationId');
        $contentId = $input->getArgument('contentId');

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $locationCreateStruct->priority = 500;
        $locationCreateStruct->hidden = true;

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $newLocation = $this->locationService->createLocation($contentInfo, $locationCreateStruct);

        $output->writeln('Added hidden location ' . $newLocation->id . ' to Content item: ' . $contentInfo->name);

        return self::SUCCESS;
    }
}
