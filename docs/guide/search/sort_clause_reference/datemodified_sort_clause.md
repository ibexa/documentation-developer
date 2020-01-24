# DateModified Sort Clause

The [`DateModified` Sort Clause](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/SortClause/DateModified.php)
sorts search results by the date and time of the last modification of a Content item.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery;
$query->sortClauses = [new SortClause\DateModified()];
```
