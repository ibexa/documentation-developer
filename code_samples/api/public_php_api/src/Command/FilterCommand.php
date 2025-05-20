<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentService;
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;
use Ibexa\Contracts\Core\Repository\Values\Filter\Filter;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(
    name: 'doc:filter'
)]
class FilterCommand extends Command
{
    private ContentService $contentService;

    public function __construct(ContentService $contentService)
    {
        $this->contentService = $contentService;

        parent::__construct();
    }

    public function configure(): void
    {
        $this->setDescription('Returns children of the provided Location, sorted by name in descending order.');
        $this->setDefinition([
            new InputArgument('parentLocationId', InputArgument::REQUIRED, 'ID of the parent Location'),
        ]);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $parentLocationId = (int)$input->getArgument('parentLocationId');

        $filter = new Filter();
        $filter
            ->withCriterion(new Criterion\ParentLocationId($parentLocationId))
            ->withSortClause(new SortClause\ContentName(Query::SORT_DESC));

        $result = $this->contentService->find($filter, []);

        $output->writeln('Found ' . $result->getTotalCount() . ' items');

        foreach ($result as $content) {
            $output->writeln($content->getName() ?? 'No content name');
        }

        return self::SUCCESS;
    }
}
