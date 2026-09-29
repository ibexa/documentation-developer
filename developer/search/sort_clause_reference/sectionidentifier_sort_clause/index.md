# SectionIdentifier Sort Clause

SectionIdentifier Sort Clause

The [`SectionIdentifier` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/SectionIdentifier.php) sorts search results by the Section IDs of the content items.

## Arguments

- (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

> **Note: Note**
>
> Solr search engine uses the `Query::SORT_DESC` sort direction by default.

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\SectionIdentifier()];
```
