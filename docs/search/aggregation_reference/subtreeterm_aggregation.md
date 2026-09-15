---
description: SubtreeTermAggregation
---

# SubtreeTermAggregation

The SubtreeTermAggregation aggregates search results by the location's subtree path.

## Arguments

- `name` - name of the Aggregation object
- `pathString` - string representing the pathstring to aggregate results by

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "SubtreeTermAggregation": {
                "name": "subtrees",
                "pathString": "/1/2/"
            }
        }
    ]
}
```
