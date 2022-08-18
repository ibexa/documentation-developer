# DatePublished Sort Clause

The [`DatePublished` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/DatePublished.php)
sorts search results by the date and time of the first publication of a Content item.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\DatePublished()];
```
