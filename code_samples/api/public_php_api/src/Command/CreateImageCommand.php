<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Core\FieldType\Image\Value;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:create_image'
)]
class CreateImageCommand
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
        OutputInterface $output,
        #[Argument(description: 'Content for the Name field')] string $name,
        #[Argument(description: 'Content for the Image field')] string $file,
        #[Option(shortcut: 'p', description: 'Do you want to publish the content item?')] bool $publish = true
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentType = $this->contentTypeService->loadContentTypeByIdentifier('image');
        $contentCreateStruct = $this->contentService->newContentCreateStruct($contentType, 'eng-GB');
        $contentCreateStruct->setField('name', $name);
        $imageValue = new Value(
            [
                'path' => $file,
                'fileSize' => filesize($file),
                'fileName' => basename((string) $file),
                'alternativeText' => $name,
            ]
        );
        $contentCreateStruct->setField('image', $imageValue);

        $locationCreateStruct = $this->locationService->newLocationCreateStruct(51);

        $draft = $this->contentService->createContent($contentCreateStruct, [$locationCreateStruct]);

        $output->writeln('Created a draft of ' . $contentType->getName() . ' with name ' . $draft->getName());

        if ($publish) {
            $content = $this->contentService->publishVersion($draft->versionInfo);
            $output->writeln('Published content item ' . $content->getName());
        }

        return Command::SUCCESS;
    }
}
