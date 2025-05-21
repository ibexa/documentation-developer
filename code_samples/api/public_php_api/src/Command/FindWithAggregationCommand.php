<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\ContentTypeTermAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Aggregation\Field\SelectionTermAggregation;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'doc:find_with_aggregation', description: 'Counts content per content type and the value of Selection Field.')]
class FindWithAggregationCommand extends Command
{
    private SearchService $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;

        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $query = new LocationQuery();
        $query->query = new Criterion\ParentLocationId(2);

        $contentTypeTermAggregation = new ContentTypeTermAggregation('content_type');
        $contentTypeTermAggregation->setLimit(5);
        $contentTypeTermAggregation->setMinCount(10);

        $query->aggregations[] = $contentTypeTermAggregation;
        $query->aggregations[] = new SelectionTermAggregation('selection', 'blog_post', 'topic');

        $results = $this->searchService->findContentInfo($query);

        $contentByType = $results->aggregations->get('content_type');
        $contentBySelection = $results->aggregations->get('selection');

        foreach ($contentByType as $contentType => $count) {
            $output->writeln($contentType->getName() . ': ' . $count);
        }

        foreach ($contentBySelection as $selection => $count) {
            $output->writeln($selection . ': ' . $count);
        }

        return self::SUCCESS;
    }
}
