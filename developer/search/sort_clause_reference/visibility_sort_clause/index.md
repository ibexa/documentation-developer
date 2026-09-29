# Visibility Sort Clause

Visibility Sort Clause

The [`Location\Visibility` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Location/Visibility.php) sorts search results by whether the location is visible or not.

Locations that aren't visible are ranked as higher values (for example, with ascending order they're returned last).

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Visibility()];
```
