# DateTrashed Sort Clause

DateTrashed Sort Clause

The [`DateTrashed` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Trash/DateTrashed.php) sorts the results of searching in Trash by the date and time when the content item was sent to trash.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();
$query->sortClauses = [new SortClause\Trash\DateTrashed()];
```
