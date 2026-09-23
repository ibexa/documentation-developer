---
description: IntegerStatsAggregation
---

# IntegerStatsAggregation

The field-based IntegerStatsAggregation aggregates search results by the value of the Integer field and provides statistical information for the values.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "IntegerStatsAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "views"
            }
        }
    ]
}
```
