<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'doc:add_location'
)]
class AddLocationToContentCommand extends Command
{
    private ContentService $contentService;

    private LocationService $locationService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(ContentService $contentService, LocationService $locationService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Add a Location to content item and hides it.')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'Content ID'),
                new InputArgument('parentLocationId', InputArgument::REQUIRED, 'Parent Location ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $parentLocationId = (int) $input->getArgument('parentLocationId');
        $contentId = (int) $input->getArgument('contentId');

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $locationCreateStruct->priority = 500;
        $locationCreateStruct->hidden = true;

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $newLocation = $this->locationService->createLocation($contentInfo, $locationCreateStruct);

        $output->writeln('Added hidden location ' . $newLocation->id . ' to content item: ' . $contentInfo->name);

        return self::SUCCESS;
    }
}
