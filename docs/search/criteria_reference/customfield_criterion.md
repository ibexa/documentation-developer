---
description: Custom Field Search Criterion
month_change: false
---

# Custom Field Criterion

The [`CustomField` Search Criterion](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-CustomField.html) searches for content or locations based on the contents of the search index fields.

The allowed syntax and operator support might differ between search engines and the type of queried field.

## Arguments

- `target` - string representing the identifier of the search index field
- `operator` - one of [Operator](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Criterion-Operator.html) constants
- `value` - the value to query for

## Limitations

The `CustomField` Criterion isn't available in [Repository filtering](search_api.md#repository-filtering).

## Example

### PHP

``` php
[[= include_code('code_samples/search/content/customfield_criterion.php') =]]
```
