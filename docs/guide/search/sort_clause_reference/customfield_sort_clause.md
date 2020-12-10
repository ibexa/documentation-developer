# CustomField Sort Clause

The [`CustomField` Sort Clause](https://github.com/ezsystems/ezplatform-kernel/blob/master/eZ/Publish/API/Repository/Values/Content/Query/SortClause/CustomField.php)
sorts search results by raw search index fields.

## Arguments

- `field` - string representing the search index field name.
- `sortDirection` (optional) - Query or LocationQuery constant, either `Query::SORT_ASC` or `Query::SORT_DESC`.

## Limitations

!!! caution

    Do not use the `CustomField` Sort Clause in production.
    It should only be used for testing.

The `CustomField` Sort Clause is not available in [Repository filtering](../../../api/public_php_api_search.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\CustomField('my_custom_field_s')];
```
