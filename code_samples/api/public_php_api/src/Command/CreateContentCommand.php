<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:create_content'
)]
class CreateContentCommand
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly ContentTypeService $contentTypeService,
        private readonly LocationService $locationService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'Parent Location ID')] int $parentLocationId,
        #[Argument(description: 'Identifier of a content type with a Name and Description Field')] string $contentType,
        #[Argument(description: 'Content for the Name field')] string $name,
        #[Option(shortcut: 'p', description: 'Do you want to publish the content item?')] bool $publish,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentTypeIdentifier = $contentType;

        $contentType = $this->contentTypeService->loadContentTypeByIdentifier($contentTypeIdentifier);
        $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
        $contentCreateStruct->setField('name', $name);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct($parentLocationId);

        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

        $output->writeln('Created a draft of ' . $contentType->getName() . ' with name ' . $draft->getName());

        if ($publish) {
            $content = $this->contentService->publishVersion($draft->versionInfo);
            $output->writeln('Published content item ' . $content->getName());
        }

        return Command::SUCCESS;
    }
}
