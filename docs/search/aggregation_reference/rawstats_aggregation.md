---
description: RawStatsAggregation
---

# RawStatsAggregation

The RawStatsAggregation aggregates search results by the value of the selected search index field and provides statistical information for the values.
You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field

## Limitations

!!! caution

    To keep your project search engine independent, don't use the `RawStatsAggregation` Aggregation in production code.
    Valid use cases are: testing, or temporary (one-off) tools.
