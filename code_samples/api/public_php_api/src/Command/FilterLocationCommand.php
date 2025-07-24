<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:filter_location',
    description: 'Returns children of the provided Location, sorted by name in descending order.'
)]
class FilterLocationCommand
{
    public function __construct(private readonly LocationService $locationService)
    {
    }

    public function __invoke(
        #[Argument(description: 'ID of the parent Location')] int $parentLocationId,
        OutputInterface $output
    ): int {
        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->locationService->find($filter, []);

        $output->writeln('Found ' . $result->getTotalCount() . ' items');

        foreach ($result as $content) {
            $output->writeln($content->getContent()->getName());
        }

        return Command::SUCCESS;
    }
}
