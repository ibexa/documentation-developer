# ContentTranslatedName Sort Clause

ContentTranslatedName Sort Clause

The [`ContentTranslatedName` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/ContentTranslatedName.php) sorts search results by the content items' translated names.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Limitations

The `ContentTranslatedName` Sort Clause isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentTranslatedName()];
```
