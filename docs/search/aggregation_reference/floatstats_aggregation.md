---
description: FloatStatsAggregation
---

# FloatStatsAggregation

The field-based FloatStatsAggregation aggregates search results by the value of the Float field and provides statistical information for the values.
You can use the provided getters to access the values:

- sum (`getSum()`)
- count of values (`getCount()`)
- minimum value (`getMin()`)
- maximum value (`getMax()`)
- average (`getAvg()`)

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "FloatStatsAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "rating"
            }
        }
    ]
}
```
