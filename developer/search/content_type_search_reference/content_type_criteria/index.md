# Content Type Search Criteria reference

Content Type Search Criteria help define and fine-tune search queries for content types.

Content Type Search Criteria are only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](../../../content_management/content_api/managing_content/index.md#finding-and-filtering-content-types).

| Criterion                                                                                                                                                                                        | Description                                                                                     |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------ | ----------------------------------------------------------------------------------------------- |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContainsFieldDefinitionId`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContainsFieldDefinitionId.php) | Matches content types that contain a field definition with the specified ID.                    |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeGroupId`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeGroupId.php)               | Matches content types by their assigned group ID.                                               |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeGroupName`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeGroupName.php)           | Matches content types by the name of their assigned group.                                      |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeId`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeId.php)                         | Matches content types by their ID.                                                              |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\ContentTypeIdentifier`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/ContentTypeIdentifier.php)         | Matches content types by their identifier.                                                      |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\IsSystem`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/IsSystem.php)                                   | Matches content types based on whether the group they belong to is system or not.               |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalAnd`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalAnd.php)                               | Implements a logical AND Criterion. It matches if ALL of the provided Criteria match.           |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalOr`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalOr.php)                                 | Implements a logical OR Criterion. It matches if at least one of the provided Criteria matches. |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\Criterion\LogicalNot`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/Criterion/LogicalNot.php)                               | Implements a logical NOT Criterion. It matches if the provided Criterion doesn't match.         |

The following example shows how to use them to search for content types:

```php
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
```
