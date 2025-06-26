<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\ObjectStateService;
use Ibexa\Contracts\Core\Repository\PermissionResolver;
use Ibexa\Contracts\Core\Repository\URLAliasService;
use Ibexa\Contracts\Core\Repository\UserService;
use Ibexa\Contracts\Core\Repository\Values\Content\VersionInfo;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:view_metadata'
)]
class ViewContentMetaDataCommand extends Command
{
    private ContentService $contentService;

    private LocationService $locationService;

    private URLAliasService $urlAliasService;

    private UserService $userService;

    private ObjectStateService $objectStateService;

    private PermissionResolver $permissionResolver;

    public function __construct(ContentService $contentService, LocationService $locationService, URLAliasService $urlAliasService, UserService $userService, ObjectStateService $objectStateService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->urlAliasService = $urlAliasService;
        $this->userService = $userService;
        $this->objectStateService = $objectStateService;
        $this->permissionResolver = $permissionResolver;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Output various metadata about a content item.')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'An existing content ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentId = (int) $input->getArgument('contentId');

        // Metadata
        $contentInfo = $this->contentService->loadContentInfo($contentId);

        $output->writeln("Name: $contentInfo->name");
        $output->writeln('Last modified: ' . $contentInfo->modificationDate->format('Y-m-d'));
        $output->writeln('Published: ' . $contentInfo->publishedDate->format('Y-m-d'));
        $output->writeln("RemoteId: $contentInfo->remoteId");
        $output->writeln("Main Language: $contentInfo->mainLanguageCode");
        $output->writeln('Always available: ' . ($contentInfo->alwaysAvailable ? 'Yes' : 'No'));

        // Locations
        $locations = $this->locationService->loadLocations($contentInfo);

        foreach ($locations as $location) {
            $output->writeln('Location: ' . $location->pathString);
            $urlAlias = $this->urlAliasService->reverseLookup($location);
            $output->writeln('URL alias: ' . $urlAlias->path);
        }

        // Content type
        $content = $this->contentService->loadContent($contentId);
        $output->writeln('Content type: ' . $content->getContentType()->getName());

        // Versions
        $versionInfos = $this->contentService->loadVersions($contentInfo);
        foreach ($versionInfos as $versionInfo) {
            $output->write("Version $versionInfo->versionNo");
            $output->write(' by ' . $versionInfo->getCreator()->getName());
            $output->writeln(' in ' . $versionInfo->getInitialLanguage()->name);
        }

        $versionInfoArray = iterator_to_array($this->contentService->loadVersions($contentInfo, VersionInfo::STATUS_ARCHIVED));
        if (count($versionInfoArray)) {
            $output->writeln('Archived versions:');
            foreach ($versionInfoArray as $versionInfo) {
                $creator = $this->userService->loadUser($versionInfo->creatorId);
                $output->write("Version $versionInfo->versionNo");
                $output->write(' by ' . $creator->contentInfo->name);
                $output->writeln(' in ' . $versionInfo->initialLanguageCode);
            }
        }

        // Relations
        $versionInfo = $this->contentService->loadVersionInfo($contentInfo);
        $relationCount = $this->contentService->countRelations($versionInfo);
        $relationList = $this->contentService->loadRelationList($versionInfo, 0, $relationCount);
        foreach ($relationList as $relationListItem) {
            $name = $relationListItem->hasRelation() ? $relationListItem->getRelation()->destinationContentInfo->name : '(Unauthorized)';
            $output->writeln("Relation to content '$name'");
        }

        // Owner
        $output->writeln('Owner: ' . $contentInfo->getOwner()->getName());

        // Section
        $output->writeln('Section: ' . $contentInfo->getSection()->name);

        // Object states
        $stateGroups = $this->objectStateService->loadObjectStateGroups();
        foreach ($stateGroups as $stateGroup) {
            $state = $this->objectStateService->getContentState($contentInfo, $stateGroup);
            $output->writeln("Object state: $state->identifier");
        }

        return self::SUCCESS;
    }
}
