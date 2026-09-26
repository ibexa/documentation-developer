# DatePublished Sort Clause

DatePublished Sort Clause

The [`DatePublished` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/DatePublished.php) sorts search results by the date and time of the first publication of a content item.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\DatePublished()];
```
