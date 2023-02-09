# UserLogin Sort Clause

The [`UserLogin` Sort Clause](https://github.com/ibexa/core/tree/main/src/contracts/Repository/Values/Content/Query/SortClause/Trash/UserLogin.php)
sorts the results of searching in Trash by the login of the Content item's creator.

## Arguments

- `sortDirection` (optional) - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\UserLogin()];
```
