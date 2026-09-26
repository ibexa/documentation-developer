# Score Sort Clause

Score Sort Clause

The [`Score` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Score.php) orders search results by their score.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Limitations

The `Score` Sort Clause isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Score()];
```
