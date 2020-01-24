# Field Sort Clause

The [`Field` Sort Clause](https://github.com/ezsystems/ezpublish-kernel/blob/v8.0.0-beta3/eZ/Publish/API/Repository/Values/Content/Query/SortClause/Field.php)
sorts search results by the value of one of the Content items' Fields.

Search results of the provided Content Type are sorted in Field value order.
Results of the query that do not belong to the Content Type are ranked lower.

## Arguments

- `typeIdentifier` - string representing the identifier of the Content Type to which the Field belongs
- `fieldIdentifier` - string representing the identified of the Field to sort by
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Example

``` php
$query = new LocationQuery;
$query->sortClauses = [new SortClause\Field('article', 'title')];
```
