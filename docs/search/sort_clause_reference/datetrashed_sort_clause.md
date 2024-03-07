# DateTrashed Sort Clause

The [`DateTrashed` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Trash/DateTrashed.php)
sorts the results of searching in Trash by the date and time when the Content item was sent to trash.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\DateTrashed()];
```
