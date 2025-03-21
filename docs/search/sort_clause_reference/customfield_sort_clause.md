---
description: CustomField Sort Clause
---

# CustomField Sort Clause

The [`CustomField` Sort Clause](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-SortClause-CustomField.html) sorts search results by raw search index fields.

## Arguments

- `field` - string representing the search index field name
[[= include_file('docs/snippets/sort_direction.md') =]]

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `CustomField` Sort Clause in production code.
    Valid use cases are: testing, or temporary (one-off) tools.

The `CustomField` Sort Clause isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

``` php
$query = new LocationQuery();
$query->sortClauses = [new SortClause\CustomField('my_custom_field_s')];
```
