<?php declare(strict_types=1);

namespace App\Command;

use eZ\Publish\API\Repository\SearchService;
use eZ\Publish\API\Repository\Values\Content\LocationQuery;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\ContentTypeTermAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Aggregation\Field\SelectionTermAggregation;
use eZ\Publish\API\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FindWithAggregationCommand extends Command
{
    private $searchService;

    public function __construct(SearchService $searchService)
    {
        $this->searchService = $searchService;
        parent::__construct('doc:find_with_aggregation');
    }

    protected function configure()
    {
        $this
            ->setDescription('Counts content per Content Type and the value of Selection Field.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $query = new LocationQuery();
        $query->query = new Criterion\ParentLocationId(2);

        $query->aggregations[] = new ContentTypeTermAggregation('content_type');
        $query->aggregations[] = new SelectionTermAggregation('selection', 'blog_post', 'topic');

        $results = $this->searchService->findContentInfo($query);

        $contentByType = $results->aggregations->get('content_type');
        $contentBySelection = $results->aggregations->get('selection');

        $query->aggregations[0]->setLimit(5);
        $query->aggregations[0]->setMinCount(10);

        foreach ($contentByType as $contentType => $count) {
            $output->writeln($contentType->getName() . ': ' . $count);
        }

        foreach ($contentBySelection as $selection => $count) {
            $output->writeln($selection . ': ' . $count);
        }

        return self::SUCCESS;
    }
}
