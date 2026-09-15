---
description: ObjectStateTermAggregation
---

# ObjectStateTermAggregation

The ObjectStateTermAggregation aggregates search results by the content item's object state.

## Arguments

- `name` - name of the Aggregation object
- `objectStateGroupIdentifier` - string representing the identifier of the object state group to aggregate results by

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "ObjectStateTermAggregation": {
                "name": "object_states",
                "objectStateGroupIdentifier": "ibexa_lock"
            }
        }
    ]
}
```
