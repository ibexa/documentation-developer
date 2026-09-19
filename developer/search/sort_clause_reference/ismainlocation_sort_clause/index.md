# IsMainLocation Sort Clause

IsMainLocation Sort Clause

The [`Location\IsMainLocation` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Location/IsMainLocation.php) sorts search results by whether their location is the main location of the content item.

Locations that aren't main locations are ranked as lower values (for example, with ascending order they're returned first).

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Limitations

The `Location\IsMainLocation` Sort Clause isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\IsMainLocation()];
```
