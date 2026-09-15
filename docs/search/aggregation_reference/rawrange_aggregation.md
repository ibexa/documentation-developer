---
description: RawRangeAggregation
---

# RawRangeAggregation

The RawRangeAggregation aggregates search results by the value of the selected search index field.

## Arguments

- `name` - name of the Aggregation object
- `field` - string representing the search index field
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "RawRangeAggregation": {
                "name": "raw_ranges",
                "fieldName": "content_version_no_i",
                "ranges": [
                    {
                        "from": null,
                        "to": 5
                    },
                    {
                        "from": 5,
                        "to": null
                    }
                ]
            }
        }
    ]
}
```

## Limitations

!!! caution

    The `RawRangeAggregation` Aggregation relies on raw search index field names, which are internal and can change.
    Don't use it in production code. Valid use cases are: testing, or temporary (one-off) tools.
