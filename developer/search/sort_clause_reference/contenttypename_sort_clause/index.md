# ContentTypeName Sort Clause

ContentTypeName Sort Clause

The [`ContentTypeName` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Trash/ContentTypeName.php) sorts the results of searching in Trash by the name of the content item's content type.

## Arguments

- (optional) `sortDirection` - Query constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\Query;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new Query();
$query->sortClauses = [new SortClause\Trash\ContentTypeName()];
```
