# ContentTypeName Sort Clause

The [`ContentTypeName` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Trash-ContentTypeName.html)
sorts the results of searching in Trash by the name of the Content item's Content Type.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\ContentTypeName()];
```
