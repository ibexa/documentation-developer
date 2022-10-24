# RawTermAggregation

The [RawTermAggregation](https://github.com/ibexa/core/blob/main/src/contracts/Repository/Values/Content/Query/Aggregation/RawTermAggregation.php) aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Limitations

!!! caution

    To keep your project search engine independent, do not use the `RawTermAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.

## Example

``` php
$query = new Query();
$query->aggregations[] = new Aggregation\RawTermAggregation('content_per_content_type', 'content_type_id_id');
```

[[= include_file('docs/snippets/search_term_aggregation_settings.md') =]]
