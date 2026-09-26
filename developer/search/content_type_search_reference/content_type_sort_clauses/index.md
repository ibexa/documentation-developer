# Content Type Search Sort Clauses

Content Type Search Sort Clauses

Content Type Search Sort Clauses are the sorting options for content types. They're only supported by [Content Type Search (`ContentTypeService::findContentTypes`)](../../../content_management/content_api/managing_content/index.md#finding-and-filtering-content-types).

Sort Clauses are found in the [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause`](https://doc.ibexa.co/en/5.0/api/php_api/php_api_reference/namespaces/ibexa-contracts-core-repository-values-contenttype-query-sortclause.html) namespace:

| Name                                                                                                                                                                | Description                       |
| ------------------------------------------------------------------------------------------------------------------------------------------------------------------- | --------------------------------- |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Id`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Id.php)                 | Sort by content type's id         |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Identifier`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Identifier.php) | Sort by content type's identifier |
| [`Ibexa\Contracts\Core\Repository\Values\ContentType\Query\SortClause\Name`](../../../../../../ibexa/core/src/contracts/Repository/Values/ContentType/Query/SortClause/Name.php)             | Sort by content type's name       |

The following example shows how to use them to sort the searched content types:

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

You can change the default sorting order by using the `SORT_ASC` and `SORT_DESC` constants from [`Ibexa\Contracts\CoreSearch\Values\Query\AbstractSortClause`](../../../../../../ibexa/core-search/src/contracts/Values/Query/AbstractSortClause.php).
