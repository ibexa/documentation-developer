# UserLogin Sort Clause

UserLogin Sort Clause

The [`UserLogin` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Trash/UserLogin.php) sorts the results of searching in Trash by the login of the content item's creator.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();
$query->sortClauses = [new SortClause\Trash\UserLogin()];
```
