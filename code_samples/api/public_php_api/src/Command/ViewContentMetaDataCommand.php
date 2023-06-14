<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\ObjectStateService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\URLAliasService;
use eZ\Publish\API\Repository\UserService;
use eZ\Publish\API\Repository\Values\Content\VersionInfo;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ViewContentMetaDataCommand extends Command
{
    private $contentService;

    private $locationService;

    private $urlAliasService;

    private $userService;

    private $objectStateService;

    private $permissionResolver;

    public function __construct(ContentService $contentService, LocationService $locationService, URLAliasService $urlAliasService, UserService $userService, ObjectStateService $objectStateService, PermissionResolver $permissionResolver)
    {
        $this->contentService = $contentService;
        $this->locationService = $locationService;
        $this->urlAliasService = $urlAliasService;
        $this->userService = $userService;
        $this->objectStateService = $objectStateService;
        $this->permissionResolver = $permissionResolver;
        parent::__construct('doc:view_metadata');
    }

    protected function configure()
    {
        $this
            ->setDescription('Output various metadata about a Content item.')
            ->setDefinition([
                new InputArgument('contentId', InputArgument::REQUIRED, 'An existing content ID'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $contentId = $input->getArgument('contentId');

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

        // Content Type
        $content = $this->contentService->loadContent($contentId);
        $output->writeln('Content Type: ' . $content->getContentType()->getName());

        // Versions
        $versionInfos = $this->contentService->loadVersions($contentInfo);
        foreach ($versionInfos as $versionInfo) {
            $output->write("Version $versionInfo->versionNo");
            $output->write(' by ' . $versionInfo->getCreator()->getName());
            $output->writeln(' in ' . $versionInfo->getInitialLanguage()->name);
        }

        $versionInfoArray = $this->contentService->loadVersions($contentInfo, VersionInfo::STATUS_ARCHIVED);
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
        $relations = $this->contentService->loadRelations($versionInfo);
        foreach ($relations as $relation) {
            $name = $relation->destinationContentInfo->name;
            $output->writeln('Relation to content ' . $name);
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
