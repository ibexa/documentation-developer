<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\SearchService;
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\Criterion;
use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_content',
    description: 'Lists content belonging to the provided content type.'
)]
class FindContentCommand
{
    public function __construct(private readonly SearchService $searchService)
    {
    }

    public function __invoke(
        #[Argument(description: 'Content type identifier')] string $contentTypeIdentifier,
        OutputInterface $output
    ): int {
        $query = new LocationQuery();
        $query->filter = new Criterion\ContentTypeIdentifier($contentTypeIdentifier);

        $result = $this->searchService->findContentInfo($query);

        $output->writeln('Found ' . $result->totalCount . ' items');
        foreach ($result->searchHits as $searchHit) {
            $output->writeln($searchHit->valueObject->name);
        }

        return Command::SUCCESS;
    }
}
