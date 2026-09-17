---
description: CountryTermAggregation
---

# CountryTermAggregation

The field-based CountryTermAggregation aggregates search results by the value of the Country field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "CountryTermAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "country"
            }
        }
    ]
}
```
