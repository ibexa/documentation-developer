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

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "RawStatsAggregation": {
                "name": "raw_stats",
                "fieldName": "content_version_no_i"
            }
        }
    ]
}
```

## Limitations

!!! caution

    The `RawStatsAggregation` Aggregation relies on raw search index field names, which are internal and can change.
    Don't use it in production code. Valid use cases are: testing, or temporary (one-off) tools.
