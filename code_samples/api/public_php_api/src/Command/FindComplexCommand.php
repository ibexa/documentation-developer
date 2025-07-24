<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_complex',
    description: 'Lists content belonging to the provided content type.'
)]
class FindComplexCommand
{
    public function __construct(private readonly SearchService $searchService, private readonly LocationService $locationService)
    {
    }

    public function __invoke(
        #[Argument(description: 'Location ID')] int $locationId,
        #[Argument(description: 'Content type identifier')] string $contentTypeIdentifier,
        #[Argument(description: 'Search text')] string $text,
        OutputInterface $output
    ): int {
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

        return Command::SUCCESS;
    }
}
