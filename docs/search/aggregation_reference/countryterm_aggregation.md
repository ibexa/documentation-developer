---
description: CountryTermAggregation
---

# CountryTermAggregation

The field-based [CountryTermAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-Field-CountryTermAggregation.html) aggregates search results by the value of the Country field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\Field\CountryTermAggregation('country', 'article', 'country');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
