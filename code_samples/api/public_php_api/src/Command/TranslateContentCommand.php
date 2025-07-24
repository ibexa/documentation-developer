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
    name: 'doc:translate_content'
)]
class TranslateContentCommand
{
    public function __construct(
        private readonly ContentService $contentService,
        private readonly UserService $userService,
        private readonly PermissionResolver $permissionResolver
    ) {
    }

    public function __invoke(
        #[Argument(description: 'ID of content to be updated')] int $contentId,
        #[Argument(description: 'Language to add')] string $language,
        #[Argument(description: 'Content name in new language')] string $nameInNewLanguage,
        #[Argument(description: 'Secondary language to add')] ?string $secondaryLanguage,
        #[Argument(description: 'Content name in secondary language')] ?string $nameInSecondaryLanguage,
        OutputInterface $output
    ): int {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $newName = $nameInNewLanguage;

        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $contentDraft = $this->contentService->createContentDraft($contentInfo);

        $contentUpdateStruct = $this->contentService->newContentUpdateStruct();
        $contentUpdateStruct->initialLanguageCode = $language;
        $contentUpdateStruct->setField('name', $newName);

        if ($nameInSecondaryLanguage !== null) {
            $contentUpdateStruct->setField('name', $nameInSecondaryLanguage, $secondaryLanguage);
        }

        $contentDraft = $this->contentService->updateContent($contentDraft->versionInfo, $contentUpdateStruct);
        $this->contentService->publishVersion($contentDraft->versionInfo);
        $output->writeln('Translated ' . $contentInfo->name . ' to ' . $language . ' as ' . $newName);

        return Command::SUCCESS;
    }
}
