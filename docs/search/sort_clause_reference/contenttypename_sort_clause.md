# ContentTypeName Sort Clause

The [`ContentTypeName` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Trash/ContentTypeName.php)
sorts the results of searching in Trash by the name of the Content item's Content Type.

## Arguments

- `sortDirection` (optional) - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\ContentTypeName()];
```
