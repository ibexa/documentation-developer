---
description: CheckboxTermAggregation
---

# CheckboxTermAggregation

The field-based CheckboxTermAggregation aggregates search results by the value of the Checkbox field.

## Arguments

[[= include_file('docs/snippets/aggregation_arguments.md') =]]

## Example

You can use this Aggregation over the REST API, in the `Aggregations` element of the payload
of the [`POST /views`](/api/rest_api/rest_api_reference/rest_api_reference.html#tag/Views/operation/ibexa.rest.views.create) request:

``` json
"Query": {
    "Aggregations": [
        {
            "CheckboxTermAggregation": {
                "name": "aggregation_name",
                "contentTypeIdentifier": "article",
                "fieldDefinitionIdentifier": "featured"
            }
        }
    ]
}
```
