# Field Sort Clause

The [`Field` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/Field.php)
sorts search results by the value of one of the content items' Fields.

Search results of the provided content type are sorted in Field value order.
Results of the query that do not belong to the content type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the content type to which the Field belongs
- `fieldIdentifier` - string representing the identifier of the Field to sort by
[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

The `Field` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\Field('article', 'title')];
```
