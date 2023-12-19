# SectionTermAggregation

The [SectionTermAggregation](../../api/php_api/php_api_reference/classes/Ibexa-Contracts-Core-Repository-Values-Content-Query-Aggregation-SectionTermAggregation.html) aggregates search results by the Content item's Section.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\SectionTermAggregation('section');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
