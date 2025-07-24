<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:set_main_location',
    description: 'Set a Location as content item\'s main'
)]
class SetMainLocationCommand
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'The Content ID')] int $contentId,
        #[Argument(description: 'One of the Locations of the Content')] int $locationId,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentInfo = $this->contentService->loadContentInfo($contentId);

        $contentUpdateStruct = $this->contentService->newContentMetadataUpdateStruct();
        $contentUpdateStruct->mainLocationId = $locationId;

        $this->contentService->updateContentMetadata($contentInfo, $contentUpdateStruct);

        $output->writeln('Location ' . $locationId . ' is now the main Location for ' . $contentInfo->name);

        return Command::SUCCESS;
    }
}
