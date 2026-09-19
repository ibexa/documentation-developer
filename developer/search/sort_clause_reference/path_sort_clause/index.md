# Path Sort Clause

Path Sort Clause

The [`Location\Path` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Location/Path.php) sorts search results by the pathString of the location.

> **Note: Note**
>
> Solr search engine uses dictionary sorting with the `Location/Path` Sort Clause.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Location\Path()];
```
