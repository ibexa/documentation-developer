# Field Sort Clause

The [`Field` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Field.php)
sorts search results by the value of one of the Content items' Fields.

Search results of the provided Content Type are sorted in Field value order.
Results of the query that do not belong to the Content Type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the Content Type to which the Field belongs
- `fieldIdentifier` - string representing the identifier of the Field to sort by
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

The `Field` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Field('article', 'title')];
```
