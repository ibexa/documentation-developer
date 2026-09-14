---
description: IntegerStatsAggregation
---

# IntegerStatsAggregation

The field-based IntegerStatsAggregation aggregates search results by the value of the Integer field and provides statistical information for the values. You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]
