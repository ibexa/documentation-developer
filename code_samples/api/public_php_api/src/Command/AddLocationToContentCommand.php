<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:add_location',
    description: 'Add a Location to content item and hides it.'
)]
class AddLocationToContentCommand
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'Content ID')] int $contentId,
        #[Argument(description: 'Parent Location ID')] int $parentLocationId,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $locationCreateStruct->priority = 500;
        $locationCreateStruct->hidden = true;

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $newLocation = $this->locationService->createLocation($contentInfo, $locationCreateStruct);

        $output->writeln('Added hidden location ' . $newLocation->id . ' to content item: ' . $contentInfo->name);

        return Command::SUCCESS;
    }
}
