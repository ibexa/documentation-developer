---
description: FloatRangeAggregation
---

# FloatRangeAggregation

The field-based FloatRangeAggregation aggregates search results by the value of the Float field.

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
            "FloatRangeAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "rating",
                "ranges": [
                    {
                        "from": null,
                        "to": 2.5
                    },
                    {
                        "from": 2.5,
                        "to": 5
                    }
                ]
            }
        }
    ]
}
```
