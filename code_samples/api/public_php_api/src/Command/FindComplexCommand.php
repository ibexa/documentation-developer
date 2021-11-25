<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use eZ\Publish\API\Repository\Values\Content\Query\SortClause;
use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\LocationService;

class FindComplexCommand extends Command
{
    private $searchService;
    private $locationService;

    public function __construct(SearchService $searchService, LocationService $locationService)
    {
        $this->searchService = $searchService;
        $this->locationService = $locationService;
        parent::__construct("doc:find_complex");
    }

    protected function configure()
    {
        $this
            ->setDescription('Lists content belonging to the provided Content Type.')
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, ''),
                new InputArgument('contentTypeIdentifier', InputArgument::REQUIRED, 'Content Type identifier'),
                new InputArgument('text', InputArgument::REQUIRED, ''),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $locationId = $input->getArgument('locationId');
        $contentTypeIdentifier = $input->getArgument('contentTypeIdentifier');
        $text = $input->getArgument('text');

        $query = new LocationQuery;

        $query->query = new Criterion\LogicalAnd([
            new Criterion\Subtree($this->locationService->loadLocation($locationId)->pathString),
            new Criterion\ContentTypeIdentifier($contentTypeIdentifier),
            new Criterion\FullText($text),
            new Criterion\LogicalNot(
                new Criterion\SectionIdentifier('Media')
            )
        ]);

        $query->sortClauses = [
            new SortClause\DatePublished(LocationQuery::SORT_ASC),
            new SortClause\ContentName(LocationQuery::SORT_DESC),
        ];

        $result = $this->searchService->findContentInfo($query);
        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->name);
        }

        return self::SUCCESS;
    }
}
