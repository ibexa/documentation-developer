<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_complex'
)]
class FindComplexCommand extends Command
{
    private SearchService $searchService;

    private LocationService $locationService;

    public function __construct(SearchService $searchService, LocationService $locationService)
    {
        $this->searchService = $searchService;
        $this->locationService = $locationService;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Lists content belonging to the provided content type.')
            ->setDefinition([
                new InputArgument('locationId', InputArgument::REQUIRED, ''),
                new InputArgument('contentTypeIdentifier', InputArgument::REQUIRED, 'Content type identifier'),
                new InputArgument('text', InputArgument::REQUIRED, ''),
            ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $locationId = (int) $input->getArgument('locationId');
        $contentTypeIdentifier = $input->getArgument('contentTypeIdentifier');
        $text = $input->getArgument('text');

        $query = new LocationQuery();

        $query->query = new Criterion\LogicalAnd([
            new Criterion\Subtree($this->locationService->loadLocation($locationId)->pathString),
            new Criterion\ContentTypeIdentifier($contentTypeIdentifier),
            new Criterion\FullText($text),
            new Criterion\LogicalNot(
                new Criterion\SectionIdentifier('Media')
            ),
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
