---
description: RawTermAggregation
---

# RawTermAggregation

The RawTermAggregation aggregates search results by the value of the selected search index field.

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
            "RawTermAggregation": {
                "name": "raw_terms",
                "fieldName": "content_type_identifier_id"
            }
        }
    ]
}
```

## Limitations

!!! caution

    The `RawTermAggregation` Aggregation relies on raw search index field names, which are internal and can change.
    Don't use it in production code. Valid use cases are: testing, or temporary (one-off) tools.
