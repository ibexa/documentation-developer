# Id Sort Clause

Id Sort Clause

The [`Location\Id` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Location/Id.php) sorts search results by the ID of the location.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Id()];
```
