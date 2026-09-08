---
description: RawTermAggregation
---

# RawTermAggregation

The RawTermAggregation aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `RawTermAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.
