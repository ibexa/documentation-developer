<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\UserService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:update_content',
    description: 'Update provided content item with a new name'
)]
class UpdateContentCommand extends Command
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'Content ID'),
                new InputArgument('newName', InputArgument::REQUIRED, 'New name for the updated content item'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentId = (int) $input->getArgument('contentId');
        $newName = $input->getArgument('newName');

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $contentDraft = $this->contentService->createContentDraft($contentInfo);

        $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
        $contentUpdateStruct->initialLanguageCode = 'eng-GB';
        $contentUpdateStruct->setField('name', $newName);

        $contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
        $this->contentService->publishVersion($contentDraft->versionInfo);

        $output->writeln('Content item ' . $contentId . ' updated with new name: ' . $newName);

        return self::SUCCESS;
    }
}
