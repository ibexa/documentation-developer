---
description: RawTermAggregation
---

# RawTermAggregation

The [RawTermAggregation](/api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-RawTermAggregation.html) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `RawTermAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\RawTermAggregation('content_per_content_type', 'content_type_id_id');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
