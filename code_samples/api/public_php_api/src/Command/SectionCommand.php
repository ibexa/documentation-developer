<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\ContentService;
use eZ\Publish\API\Repository\PermissionResolver;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\SectionService;
use eZ\Publish\API\Repository\UserService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SectionCommand extends Command
{
    private $sectionService;

    private $userService;

    private $searchService;

    private $contentService;

    private $permissionResolver;

    public function __construct(SectionService $sectionService, UserService $userService, ContentService $contentService, SearchService $searchService, PermissionResolver $permissionResolver)
    {
        $this->sectionService = $sectionService;
        $this->userService = $userService;
        $this->permissionResolver = $permissionResolver;
        $this->searchService = $searchService;
        $this->contentService = $contentService;
        parent::__construct('doc:section');
    }

    protected function configure()
    {
        $this
            ->setDescription('Creates new section and adds selected Content item to it.')
            ->setDefinition([
                new InputArgument('sectionName', InputArgument::REQUIRED, 'Name of the new Section'),
                new InputArgument('sectionIdentifier', InputArgument::REQUIRED, 'Identifier of the new Section'),
                new InputArgument('contentId', InputArgument::REQUIRED, 'Content id'),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $user = $this->userService->loadUserByLogin('admin');
        $this->permissionResolver->setCurrentUserReference($user);

        $sectionName = $input->getArgument('sectionName');
        $sectionIdentifier = $input->getArgument('sectionIdentifier');
        $contentId = $input->getArgument('contentId');

        $sectionCreateStruct = $this->sectionService->newSectionCreateStruct();
        $sectionCreateStruct->name = $sectionName;
        $sectionCreateStruct->identifier = $sectionIdentifier;
        $this->sectionService->createSection($sectionCreateStruct);
        $output->writeln('Created new Section ' . $sectionName);

        $section = $this->sectionService->loadSectionByIdentifier($sectionIdentifier);
        $contentInfo = $this->contentService->loadContentInfo($contentId);
        $this->sectionService->assignSection($contentInfo, $section);
        $output->writeln('Content ' . $contentInfo->name . ' assigned to Section ' . $sectionName);

        $query = new LocationQuery();
        $query->filter = new Criterion\SectionId([
            $section->id,
        ]);

        $result = $this->searchService->findContentInfo($query);

        $output->writeln((
            $this->sectionService->isSectionUsed($section)
            ? 'This section is in use.'
            : 'This section is not in use.'
        ));
        $output->writeln('Content in this section: ' . $result->totalCount);

        foreach ($result->searchHits as $searchResult) {
            $output->writeln('* ' . $searchResult->valueObject->name);
        }

        return self::SUCCESS;
    }
}
