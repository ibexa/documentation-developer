---
description: DateMetadataRangeAggregation
---

# DateMetadataRangeAggregation

The DateMetadataRangeAggregation aggregates search results by the value of the content items' date metadata.

## Arguments

- `name` - name of the Aggregation object
- `type` - string representing the type of the Aggregation (`MODIFIED` or `PUBLISHED`)
- `ranges` - array of Range objects that define the borders of the specific range sets

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "DateMetadataRangeAggregation": {
                "name": "modification_date",
                "type": "modified",
                "ranges": [
                    {
                        "from": null,
                        "to": "2024-01-01T00:00:00+00:00"
                    },
                    {
                        "from": "2024-01-01T00:00:00+00:00",
                        "to": null
                    }
                ]
            }
        }
    ]
}
```
