# ContentName Sort Clause

The [`ContentName` Sort Clause](https://github.com/ezsystems/ezpublish-kernel/blob/v7.5.6/eZ/Publish/API/Repository/Values/Content/Query/SortClause/ContentName.php)
sorts search results by the Content items' names.

## Arguments

- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\ContentName()];
```
