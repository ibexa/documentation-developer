# UserLogin Sort Clause

The [`UserLogin` Sort Clause](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-Trash-UserLogin.html)
sorts the results of searching in Trash by the login of the Content item's creator.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\UserLogin()];
```
