---
description: TimeRangeAggregation
---

# TimeRangeAggregation

The field-based TimeRangeAggregation aggregates search results by the value of the Date, DateTime, or Time field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "TimeRangeAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "event",
                "fieldDefinitionIdentifier": "start_time",
                "ranges": [
                    {
                        "from": 0,
                        "to": 43200
                    },
                    {
                        "from": 43200,
                        "to": 86400
                    }
                ]
            }
        }
    ]
}
```
