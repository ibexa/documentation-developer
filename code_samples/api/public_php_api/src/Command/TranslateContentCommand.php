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
    name: 'doc:translate_content'
)]
class TranslateContentCommand extends Command
{
    private ContentService $contentService;

    private UserService $userService;

    private PermissionResolver $permissionResolver;

    public function __construct(ContentService $contentService, UserService $userService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'ID of content to be updated'),
                new InputArgument('language', InputArgument::REQUIRED, 'Language to add'),
                new InputArgument('nameInNewLanguage', InputArgument::REQUIRED, 'Content name in new language'),
                new InputArgument('secondaryLanguage', InputArgument::OPTIONAL, 'Secondary language to add'),
                new InputArgument('nameInSecondaryLanguage', InputArgument::OPTIONAL, 'Content name in secondary language'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentId = (int) $input->getArgument('contentId');
        $language = $input->getArgument('language');
        $newName = $input->getArgument('nameInNewLanguage');
        $secondaryLanguage = $input->getArgument('secondaryLanguage');
        $nameInSecondaryLanguage = $input->getArgument('nameInSecondaryLanguage');

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

        return self::SUCCESS;
    }
}
