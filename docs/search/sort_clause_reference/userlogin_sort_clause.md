# UserLogin Sort Clause

The [`UserLogin` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Trash/UserLogin.php)
sorts the results of searching in Trash by the login of the content item's creator.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

``` php
$query = new Query();
$query->sortClauses = [new SortClause\Trash\UserLogin()];
```
