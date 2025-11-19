<?php declare(strict_types=1);

namespace App\Command;

use Ibexa\Contracts\Core\Repository\ContentTypeService;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\ContentTypeQuery;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion;
use Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'doc:find_content_types',
    description: 'Lists content types that match specific criteria.'
)]
class FindContentTypeCommand extends Command
{
    public function __construct(private readonly ContentTypeService $contentTypeService)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Find content types from the "Content" group that contains a specific field definition (in this case, a "Body" field).
        $query = new ContentTypeQuery(
            new Criterion\LogicalAnd([
                new Criterion\ContentTypeGroupName(['Content']),
                new Criterion\ContainsFieldDefinitionId([121]),
            ]),
            [
                new SortClause\Id(),
                new SortClause\Identifier(),
                new SortClause\Name(),
            ]
        );

        $searchResult = $this->contentTypeService->findContentTypes($query);

        $output->writeln('Found ' . $searchResult->getTotalCount() . ' content type(s):');

        foreach ($searchResult->getContentTypes() as $contentType) {
            $output->writeln(sprintf(
                '- [%d] %s (identifier: %s)',
                $contentType->id,
                $contentType->getName(),
                $contentType->identifier
            ));
        }

        return Command::SUCCESS;
    }
}
