# CustomField Sort Clause

The [`CustomField` Sort Clause](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/SortClause/CustomField.php)
sorts search results by raw search index fields.

## Arguments

- `field` - string representing the search index field name.
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

!!! caution

    To keep your project search engine independent, do not use the `CustomField` Sort Clause in production code.
    Valid use cases are: testing, or temporary (one-off) tools.

The `CustomField` Sort Clause is not available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\CustomField('my_custom_field_s')];
```
