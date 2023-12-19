# DateTrashed Sort Clause

The [`DateTrashed` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Trash-DateTrashed.html)
sorts the results of searching in Trash by the date and time when the Content item was sent to trash.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\DateTrashed()];
```
