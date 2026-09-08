---
description: RawRangeAggregation
---

# RawRangeAggregation

The RawRangeAggregation aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field
- `ranges` - array of Range objects that define the borders of the specific range sets

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `RawRangeAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.
