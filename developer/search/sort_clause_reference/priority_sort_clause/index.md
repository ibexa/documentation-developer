# Priority Sort Clause

Priority Sort Clause

The [`Location\Priority` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Location/Priority.php) sorts search results by the priority of the location.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Priority()];
```
