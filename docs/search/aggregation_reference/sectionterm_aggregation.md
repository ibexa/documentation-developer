# SectionTermAggregation

The [SectionTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/SectionTermAggregation.php) aggregates search results by the content item's Section.

## Arguments

- `name` - name of the Aggregation object

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\SectionTermAggregation('section');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
