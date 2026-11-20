# Field Sort Clause

Field Sort Clause

The [`Field` Sort Clause](../../../../../../ibexa/core/src/contracts/Repository/Values/Content/Query/SortClause/Field.php) sorts search results by the value of one of the content items' fields.

Search results of the provided content type are sorted in field value order. Results of the query that don't belong to the content type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the field belongs
- `fieldIdentifier` - string representing the identifier of the field to sort by - (optional) `sortDirection` - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`

## Limitations

The `Field` Sort Clause isn't available in [Repository filtering](../../search_api/index.md#repository-filtering).

## Example

```php
use Ibexa\Contracts\Core\Repository\Values\Content\LocationQuery;
use Ibexa\Contracts\Core\Repository\Values\Content\Query\SortClause;

$query = new LocationQuery();
$query->sortClauses = [new SortClause\Field('article', 'title')];
```
